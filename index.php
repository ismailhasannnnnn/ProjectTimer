<?php
/**
 * @Author: Ismail Hasan && Justin Gonzales
 * @Version: 0.1
 * @Since: 6/11/2018
 *
 */
include("connect.php");
session_start();
if (isset($_SESSION['login_user'])) {
    header("Location: mainpage.php");
}

?>

<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans" rel="stylesheet">

    <title> Senior Project Logger </title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/png" href="assets/clockicon.png">

</head>

<body>

<!--   Javascript for elements -->

<nav class="top-bar">
    <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
            <li class="menu-text"><a id="topbarlogo" href="index.php"> Senior Project Logger</a></li>
            <li><a href="#"> Learn more</a></li>
            <li><a href="#"> Contact us</a></li>

        </ul>
    </div>
    <div class="top-bar-right">
        <ul class="dropdown menu" data-dropdown-menu>
            <li><a href="#"><button class="roundbuttons" onclick="location.href='login.php'"> Login </button></a></li>
        </ul>
    </div>
</nav>

<div class="row" id="middiv">
    <div class="columns large-6" align="center">
        <img id="logo" src="assets/Senior%20Project%20Logo%20Iteration%202%20.png">
    </div>
    <div class="desc" align="center">
        <button class="roundbuttons2" onclick="location.href='register.php'"> Get Started </button>
    </div>
</div>
<div class="row" id="bottomdiv">
    <div class="columns large-6" align="center">
        <h1> <b> Timing? We'll take care of that. </b></h1>
        <p> Senior Project Logger is a simple but effective timer that helps you keep track of how much time you've spent on your project. A clock-in clock-out system ensures that all you need to worry about is your actual project. Just create an account and you're good to go! </p>
        <img id="clock" src="assets/white%20clock.png">
    </div>
</div>
<div class="row" id="creditsdiv">
    <div class="columns large-6" align="center">
        <h2> Reach us at <u>seniorprojectlogo@gmail.com</u> </h2>
        <br>
        <h3>The SPL was created by Marcus Barga, Justin Gonzales, and Ismail Hasan.</h3>
    </div>
</div>
</body>

<!--   Javascript for Elements  -->

<script>
    jQuery.noConflict();
</script>
<script src="jquery-3.3.1.min.js"></script>
<script>
    $(function() {
        $("#middiv").hide().delay(10).fadeIn(2000);
        $("#bottomdiv").hide().delay(10).fadeIn(2000);
        $("#creditsdiv").hide().delay(10).fadeIn(2000);
    });
</script>

<!--   JavaScript-->

</html>
