<?php

/**
 * @Author: Ismail Hasan && Justin Gonzales
 * @Version: 0.1
 * @Since: 6/11/2018
 *
 */

include("connect.php");
date_default_timezone_set("America/Los_Angeles");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $secondPassword = mysqli_real_escape_string($con, $_POST['secondPassword']);
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);

    $sql = "SELECT * FROM logins WHERE Username = '$name'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $count = mysqli_num_rows($result);

    if($count == 0 && $password === $secondPassword){
        $sql2 = "INSERT INTO logins (Username, Password, PhoneNumber) VALUES ('$name', '$password', '$phoneNumber')";
        mysqli_query($con, $sql2);
        header("Location: login.php");
    }else if($count == 0 && $password !== $secondPassword){
        $passwordError = "Passwords do not match, please try again.";
    }
    else{
        $error = "Username already taken";
    }


}


?>

<html>
<head>
    <meta charset="utf-8">
    <title>SP Logger</title>
</head>
<body>
<form action="" method="POST" id="register">
    <div style="text-align: center">
        <h1>Register: </h1>
        <input placeholder="Username" style="text-align: center" title="usernameField" type="text" name="name" class="box" required>
        <br>
        <!--<?php echo $name ?>-->
        <br>
        <input placeholder="Password" style="text-align: center;" title="passwordField" type="password" name="password" class="box" minlength="8" maxlength="16" required>
        <br>
        <p style="font-size: 15px">Please have a password of 8 to 16 characters in length.</p>
        <input placeholder="Re-enter Password" style="text-align: center" title="reEnterPasswordField" type="password" name="secondPassword" minlength="8" maxlength="16" required>
        <br>
        <div align="center" style="font-size:15px"><br><?php echo $passwordError;?></div>
        <br>
        <input placeholder="Phone Number (Optional)" style="text-align: center" title="phoneNumberField" type="text" name="phoneNumber" class="box">
        <br>
        <!--<?php echo $phoneNumber ?>-->
        <br>
        <input type="submit" value="Register" class="submitButton" name="Submit">
        <div align="center" style="font-size:15px"><?php echo $error;?></div>
    </div>
</form>
<div style="text-align: center">
    <button onclick="location.href='index.php'">Home</button>
</div>
</body>
</html>

