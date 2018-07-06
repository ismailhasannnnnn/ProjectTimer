<?php

/**
 * @Author: Ismail Hasan && Justin Gonzales
 * @Version: 0.1
 * @Since: 6/11/2018
 *
 */

session_start();
unset($_SESSION['login_user']);
date_default_timezone_set("America/Los_Angeles");

header("Location: index.php");