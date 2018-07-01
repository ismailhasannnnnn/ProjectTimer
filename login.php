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

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $sql = "SELECT * FROM logins WHERE Username = '$name' AND Password = '$password'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION['login_user'] = $name;

        header("location: mainpage.php");
    }else {
        $error = "Your Password is invalid";
    }


}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>SP Logger</title>
</head>
<body>
<form action="" method="POST" id="login">
    <div style="text-align: center">
        <h1 style="text-align: center">Login:</h1>
        <input placeholder="Username" style="text-align: center" title="usernameField" type="text" name="name">
        <br>
        <br>
        <input placeholder="Password" style="text-align: center;" title="passwordField" type="password" name="password">
        <br>
        <br>
        <button>Login</button>
        <br>
        <?php echo $error ?>
    </div>
</form>
<br>
<div style="text-align: center">
    <button onclick="location.href='index.php'">Home</button>
</div>
<br>

