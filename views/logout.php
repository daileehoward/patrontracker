<?php

session_start();
session_destroy();

if ($_SESSION['page'] != 'status.php') {
    //stay on same page
    header("location: " . $_SESSION['page']);
} else if($_SESSION['page'] == 'status.php') {
    //Redirect to login
    header("location: login.html");
}

