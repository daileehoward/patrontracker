<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);


if(isset($_SESSION['loggedin'])) {

    //Store the page that I'm currently on in the session
    $_SESSION['page'] = $_SERVER['SCRIPT_URI'];
}

