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
}

function clockIn()
{
    $name = $_SESSION['login_user'];
    $date = date("Y/m/d");
    $firstTime = date("h:i:s");
//    $clockInSQL = "INSERT INTO clockLogs (Username, ClockedIn) VALUES ('$name', TRUE)";
//    mysqli_query($GLOBALS['con'], $clockInSQL);
    $sql = "SELECT * FROM clockLogs WHERE Username = '$name'";
    $result = mysqli_query($GLOBALS['con'], $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $clockInSQL = "UPDATE clockLogs SET ClockedIn = TRUE WHERE Username = '$name'";
        mysqli_query($GLOBALS['con'], $clockInSQL);
        $timeSQL = "INSERT INTO timeLogs (Username, Date, clockInTime) VALUES ('$name', '$date', '$firstTime')";
        mysqli_query($GLOBALS['con'], $timeSQL);
        echo "Clocked in.";
    } else {
        $clockInSQL = "INSERT INTO clockLogs (Username, ClockedIn) VALUES ('$name', TRUE)";
        mysqli_query($GLOBALS['con'], $clockInSQL);
        $timeSQL = "INSERT INTO timeLogs (Username, Date, clockInTime) VALUES ('$name', '$date', '$firstTime')";
        mysqli_query($GLOBALS['con'], $timeSQL);
        echo "Clocked in.";
    }
}

function clockOut()
{
    $name = $_SESSION['login_user'];
    $firstNameSQL = "SELECT clockInTime FROM timeLogs WHERE Username = 'ismail' AND clockOutTime = '00:00:00'";
    $result = mysqli_query($GLOBALS['con'], $firstNameSQL);
    $row = mysqli_fetch_array($result);
    $firstTime = $row['clockInTime'];
    $secondTime = date("h:i:s");
    $clockOutSQL = "UPDATE clockLogs SET ClockedIn = FALSE WHERE Username = '$name'";
    mysqli_query($GLOBALS['con'], $clockOutSQL);
    $timeSQL = "UPDATE timeLogs SET clockOutTime = '$secondTime' WHERE Username = '$name' AND clockInTime = '$firstTime'";
    mysqli_query($GLOBALS['con'], $timeSQL);

    $timeSpentQuery = mysqli_query($GLOBALS['con'], "SELECT TIMEDIFF('$secondTime', '$firstTime')");
    $timeSpentResult = mysqli_fetch_array($timeSpentQuery);
    $timeSpent = $timeSpentResult['time_diff'];
    $timeSpentSQL = "UPDATE timeLogs SET timeSpent = 'SELECT TIMEDIFF('$secondTime', '$firstTime')' WHERE Username = '$name' AND clockInTime = '$firstTime' AND clockOutTime = '$secondTime'";
    mysqli_query($GLOBALS['con'], $timeSpentSQL);
    echo $timeSpent;
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

<form method="POST" action="mainpage.php">
    <input type="submit" value="Clock In" name="clockin">
    <br>
    <input type="submit" value="Clock Out" name="clockout">
</form>
</body>
</html>