<?php
/**
 * @Author: Ismail Hasan && Justin Gonzales
 * @Version: 0.1
 * @Since: 6/11/2018
 *
 */
include("connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $loginName = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $secondPassword = mysqli_real_escape_string($con, $_POST['secondPassword']);

    $sql = "SELECT * FROM logins WHERE Username = '$name'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $count = mysqli_num_rows($result);

    if ($count == 0 && $password === $secondPassword) {
        $sql2 = "INSERT INTO logins (Username, Password, PhoneNumber) VALUES ('$name', '$password', '$phoneNumber')";
        mysqli_query($con, $sql2);
        header("Location: index.php");
    } else if ($count == 0 && $password !== $secondPassword) {
        $passwordError = "Passwords don't match.";
    } else {
        $error = "Username already taken";
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Senior Project Logger Register Page</title>
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="css/register.css">


</head>

<body>

<script>
    function myFunction() {
        location.href = index.php;
    }
</script>

<script>
    div.addEventListener("click", myFunction);
</script>


<form action="" method="POST" id="register">

    <div id="top-question">
        <a class="a" href="//coder696.org/wip"> What is the Senior Project Logger? </a>
    </div>


    <div id="main">


        <header class="logo"><img id="logo" src="assets/Senior%20Project%20Logo%20Iteration%202%20.png"
                                  alt="Senior Project Logo"></header>


        <div id="textbox">
            <input class="textbox" placeholder="Username" style="text-align: center" title="usernameField" type="text"
                   name="name" class="box" required>

        </div>

        <!--<?php echo $name ?>-->


        <div id="textbox"><input class="textbox" placeholder="Password" class="password" style="text-align: center;"
                                 title="passwordField" type="password" name="password" class="box" minlength="8"
                                 maxlength="16" required>


            <div class="tooltip">
                <span class="tooltiptext">The password must be 8-20 characters long</span>
            </div>


        </div>


        <div id="textbox"><input class="textbox" placeholder="Re-enter Password" class="password"
                                 style="text-align: center" title="reEnterPasswordField" type="password"
                                 name="secondPassword" minlength="8" maxlength="16" required>
        </div>

        <div>
            <?php echo $passwordError; ?>
        </div>


        <div id="textbox"><input placeholder="Phone Number (Optional)" style="text-align: center"
                                 title="phoneNumberField" type="text" name="phoneNumber" class="box"></div>


        <!--<?php echo $phoneNumber ?>-->


        <!--        <input type="submit" value="Register" class="submitButton" name="Submit">-->


        <div align="center" style="font-size:15px">
            <?php echo $error; ?>
        </div>

        <div class="buttons" align="center">

            <!--<button class="btn" onclick="location.href='index.php'"> Sign up  </button>-->
            <input type="submit" class="btn" value=" Sign Up " name="submit">

        </div>


    </div>


</form>


</body>
</html>