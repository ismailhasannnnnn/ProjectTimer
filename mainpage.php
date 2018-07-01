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
        echo "Clocked in.";
    } else {
        $clockInSQL = "INSERT INTO clockLogs (Username, ClockedIn) VALUES ('$name', TRUE)";
        mysqli_query($GLOBALS['con'], $clockInSQL);
        $timeSQL = "INSERT INTO timeLogs (Username, clockIn) VALUES ('$name', '$clockInEntry')";
        mysqli_query($GLOBALS['con'], $timeSQL);
        echo "Clocked in.";
    }
}

function clockOut()
{
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

    $timeSpentQuery = mysqli_query($GLOBALS['con'], "SELECT TIMESTAMPDIFF(SECOND, '$clockInEntry', '$clockOutEntry')");
    $timeSpentResult = mysqli_fetch_array($timeSpentQuery);
    $timeSpent = $timeSpentResult["TIMESTAMPDIFF(SECOND, '$clockInEntry', '$clockOutEntry')"];
    $formatQuery = mysqli_query($GLOBALS['con'], "SELECT SEC_TO_TIME('$timeSpent')");
    $formatResult = mysqli_fetch_array($formatQuery);
    $formattedTimeSpent = $formatResult["SEC_TO_TIME('$timeSpent')"];
    $timeSpentSQL = "UPDATE timeLogs SET timeSpent = '$formattedTimeSpent' WHERE Username = '$name' AND clockIn = '$clockInEntry' AND clockOut = '$clockOutEntry'";
    mysqli_query($GLOBALS['con'], $timeSpentSQL);
    echo "Clocked out.";
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