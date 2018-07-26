<?php

/**
 * @Author: Ismail Hasan && Justin Gonzales
 * @Version: 0.1
 * @Since: 6/11/2018
 *
 */

include("connect.php");
session_start();
date_default_timezone_set("America/Los_Angeles");

if (isset($_POST['clockin'])) {
    clockIn();
} else if (isset($_POST['clockout'])) {
    clockOut();
}else if(isset($_POST['saveFile'])){
    saveFile();
}

function clockIn()
{
    $name = $_SESSION['login_user'];
    $clockInEntry = date("Y/m/d") . " " . date("H:i:s");
//    $clockInSQL = "INSERT INTO clockLogs (Username, ClockedIn) VALUES ('$name', TRUE)";
//    mysqli_query($GLOBALS['con'], $clockInSQL);
    $sql = "SELECT * FROM clockLogs WHERE Username = '$name'";
    $result = mysqli_query($GLOBALS['con'], $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $clockInSQL = "UPDATE clockLogs SET ClockedIn = TRUE WHERE Username = '$name'";
        mysqli_query($GLOBALS['con'], $clockInSQL);
        $timeSQL = "INSERT INTO timeLogs (Username, clockIn) VALUES ('$name', '$clockInEntry')";
        mysqli_query($GLOBALS['con'], $timeSQL);
    } else {
        $clockInSQL = "INSERT INTO clockLogs (Username, ClockedIn) VALUES ('$name', TRUE)";
        mysqli_query($GLOBALS['con'], $clockInSQL);
        $timeSQL = "INSERT INTO timeLogs (Username, clockIn) VALUES ('$name', '$clockInEntry')";
        mysqli_query($GLOBALS['con'], $timeSQL);
    }
}

function clockOut()
{

    /*
     * Fills in the data that was when clocking in, which is the clockOut column. The TimeSpent column isn't filled yet.
     */
    $name = $_SESSION['login_user'];
    $firstNameSQL = "SELECT clockIn FROM timeLogs WHERE Username = '$name' AND clockOut = '0000-00-00 00:00:00'";
    $result = mysqli_query($GLOBALS['con'], $firstNameSQL);
    $row = mysqli_fetch_array($result);
    $clockInEntry = $row['clockIn'];
    $clockOutEntry = date("Y/m/d") . " " . date("H:i:s");
    $clockOutSQL = "UPDATE clockLogs SET ClockedIn = FALSE WHERE Username = '$name'";
    mysqli_query($GLOBALS['con'], $clockOutSQL);
    $timeSQL = "UPDATE timeLogs SET clockOut = '$clockOutEntry' WHERE Username = '$name' AND clockIn = '$clockInEntry'";
    mysqli_query($GLOBALS['con'], $timeSQL);

    /*
     * This is where the timeSpent column is filled in, the math is done using a SQL function.
     */

    $timeSpentQuery = mysqli_query($GLOBALS['con'], "SELECT TIMESTAMPDIFF(SECOND, '$clockInEntry', '$clockOutEntry')");
    $timeSpentResult = mysqli_fetch_array($timeSpentQuery);
    $timeSpent = $timeSpentResult["TIMESTAMPDIFF(SECOND, '$clockInEntry', '$clockOutEntry')"];
    $formatQuery = mysqli_query($GLOBALS['con'], "SELECT SEC_TO_TIME('$timeSpent')");
    $formatResult = mysqli_fetch_array($formatQuery);
    $formattedTimeSpent = $formatResult["SEC_TO_TIME('$timeSpent')"];
    $timeSpentSQL = "UPDATE timeLogs SET timeSpent = '$formattedTimeSpent' WHERE Username = '$name' AND clockIn = '$clockInEntry' AND clockOut = '$clockOutEntry'";
    mysqli_query($GLOBALS['con'], $timeSpentSQL);

    /*
     * Once all the data is clocked in, and the entry is fully completed, we will export all the table data for this
     */

    $csvString = "";
    $exportQuery = "SELECT * FROM timeLogs WHERE Username='$name'";
    $exportResult = mysqli_query($GLOBALS['con'], $exportQuery);
    while($row = mysqli_fetch_array($exportResult)){

        $a = $row["Username"];
        $b =  $row["clockIn"];
        $c = $row["clockOut"];
        $d = $row["timeSpent"];

        $csvString .= "\"$a\",\"$b\",\"$c\",\"$d\"\n";

    }

    file_put_contents("exportedData/".$name.".csv", $csvString);
}

function saveFile(){
    $url = "https://i.ytimg.com/vi/gvfDAcKzCco/maxresdefault.jpg";
    $filename = basename($url);

    file_put_contents($filename, file_get_contents($url));
}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>SP Logger</title>
</head>
<body>
<div style="text-align: right; font-size: 35px;">
    <?php
    echo "Logged in as " . $_SESSION['login_user'];
    ?>
</div>
<br>
<div style="text-align: center">
    <button onclick="location.href='index.php'">Home</button>
</div>
<br>
<div style="text-align: center">
    <form method="POST" action="logout.php">
        <input type="submit" value="Log Out" name="logOut">
    </form>

    <form method="POST" action="mainpage.php">

        <?php
        $name = $_SESSION['login_user'];
        $queryResult = mysqli_query($con, "SELECT ClockedIn FROM clockLogs WHERE Username='$name'");
        $resultArray = mysqli_fetch_array($queryResult);
        $clockedIn = $resultArray["ClockedIn"];

        if ($clockedIn == 0) {
            echo "<input type='submit' value='Clock In' name='clockin'>";
        } else if ($clockedIn == 1) {
            echo "<input type='submit' value='Clock Out' name='clockout'>";
        }

        ?>

    </form>
</div>

<br>

<div style="text-align: center">
    <?php
    $name = $_SESSION['login_user'];
    $queryResult = mysqli_query($con, "SELECT ClockedIn FROM clockLogs WHERE Username='$name'");
    $resultArray = mysqli_fetch_array($queryResult);
    $clockedIn = $resultArray["ClockedIn"];

    if ($clockedIn == 0) {
        echo "Clocked out.";
    } else if ($clockedIn == 1) {
        echo "Clocked in.";
    }

    ?>
</div>

<br>
<div style="text-align: center">
    <?php
    $name = $_SESSION['login_user'];
    echo "Total time spent on project: ";
    $timeSQL = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( timeSpent ) ) ) FROM timeLogs WHERE Username='$name'";
    $timeResult = mysqli_query($con, $timeSQL);
    $timeRows = mysqli_fetch_array($timeResult);
    $timeNumberRows = mysqli_num_rows($timeResult);
    $timeTotal = $timeRows['SEC_TO_TIME( SUM( TIME_TO_SEC( timeSpent ) ) )'];
    print_r($timeTotal);
    ?>
</div>
<br>
<br>
<div style="text-align: center;">
    <!--    <form method="post" action="mainpage.php">-->
    <!--        <input type="submit" value="Download" name="saveFile">-->
    <!--    </form>-->
    <?php
    echo "<a href=exportedData/$name.csv download=$name.csv>
        <button>Download</button>
        </a>"
    ?>
</div>
</body>
</html>