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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $loginName = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $secondPassword = mysqli_real_escape_string($con, $_POST['secondPassword']);

    $sql = "SELECT * FROM logins WHERE Username = '$name'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $count = mysqli_num_rows($result);

    if($count == 0 && $password === $secondPassword){
        $sql2 = "INSERT INTO logins (Username, Password, PhoneNumber) VALUES ('$name', '$password', '$phoneNumber')";
        mysqli_query($con, $sql2);
    }else if($count == 0 && $password !== $secondPassword){
        $passwordError = "Passwords don't match.";
    }else{
        $error = "Username already taken";
    }


}


?>

<!DOCTYPE html>
<html>
<head>
    <title> Senior Project Logger </title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/button.css">
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Condensed" rel="stylesheet">
    <meta charset="UTF-8">
</head>
<body>
<script>
    jQuery.noConflict();

</script>
<script src="jquery-3.3.1.min.js"></script>
<script>
    $(function(){
        $("div.buttons").hide().delay(10).fadeIn(2000);
        $("#credits").hide().delay(10).fadeIn(2000);
        $("#logo").hide().delay(10).fadeIn(2000);
    });
</script>

<div id="top-question">
    <a class="a" href="http://coder696.org/wip"> What is the Senior Project Logger? </a>
</div>
<div style="text-align: right">
    <?php
    if(isset($_SESSION['login_user'])){
        echo "<div style=\"text-align: center\">
            <button onclick=\"location.href='logout.php'\">Log out</button>
            </div>";
        echo "Logged in as " . $_SESSION['login_user'];
    }else{
        echo "<div>Not logged in.</div>";
    }
    ?>
</div>
<header class="logo" >
    <img id="logo"  src="images/Senior%20Project%20Logo%20Iteration%202.png" alt="Senior Project Logo" >
</header>

<!--<div style="text-align: center">-->
<!--    <button onclick="location.href='login.php'" style="">Log in</button>-->
<!--</div>-->

<!--<br>-->

<!--<div style="text-align: center">-->
<!--    <button onclick="location.href='register.php'" style="">Register</button>-->
<!--</div>-->

<!--<br>-->

<div class="buttons">
    <button type="button" class="btn" onclick="location.href='register.php'"> Get Started </button>
    <button class="btn" onclick="location.href='login.php'"> Login </button>
</div>

<div id="credits">

    Created by Ismail Hasan and Justin Gonzales

</div>


</body>
</html>
