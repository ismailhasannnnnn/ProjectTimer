<?php
/**
 * Created by PhpStorm.
 * User: ismai
 * Date: 6/26/2018
 * Time: 11:15 PM
 */

$servername = "localhost";
$username = "ismailha_ismail";
$password = "Stripes12";
$dbName = "ismailha_seniorprojectlogger";
date_default_timezone_set("America/Los_Angeles");

$con = mysqli_connect($servername, $username, $password, $dbName);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}