<?php

/**
 * @Author: Ismail Hasan && Justin Gonzales
 * @Version: 0.1
 * @Since: 6/11/2018
 *
 */

include("connect.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);

    $sql = "INSERT INTO logins (Username, Password, PhoneNumber) VALUES ('$name', '$password', '$phoneNumber')";

    mysqli_query($con, $sql);


}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SP Logger</title>
</head>
<body>
<form action="login.php" method="get" id="register">
    <div style="text-align: center">
        <h1 style="text-align: center">Login:</h1>
        <input placeholder="Username" style="text-align: center" title="usernameField" type="text">
        <br>
        <br>
        <input placeholder="Password" style="text-align: center;" title="passwordField" type="password">
        <br>
        <br>
        <button>Login</button>
    </div></form>
<br>
<form action="" method="POST" id="register">
    <div style="text-align: center">
        <h1>Register: </h1>
        <input placeholder="Username" style="text-align: center" title="usernameField" type="text" name="name" class="box">
        <br>
        <!--<?php echo $name ?>-->
        <br>
        <input placeholder="Password" style="text-align: center;" title="passwordField" type="password" name="password" class="box">
        <br>
        <!--<?php echo $password ?>-->
        <br>
        <input placeholder="Re-enter Password" style="text-align: center" title="reEnterPasswordField" type="password">
        <br>
        <br>
        <input placeholder="Phone Number (Optional)" style="text-align: center" title="phoneNumberField" type="text" name="phoneNumber" class="box">
        <br>
        <!--<?php echo $phoneNumber ?>-->
        <br>
        <input type="submit" value="Register" class="submitButton" name="Submit">
    </div>
</form>

</body>
</html>
