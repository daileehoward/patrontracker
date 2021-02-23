<?php
//This is my CONTROLLER

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require files
require_once('vendor/autoload.php');

//Start a session
session_start();

//Create an instance of the Base class
$f3 = Base::instance();

//add classes
$controller = new Controller($f3);
$dataLayer = new DataLayer();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route (login page)
$f3->route('GET /', function () {
    global $controller;
    $controller->login();
});

//Define a "status" route
$f3->route('GET|POST /status', function () {
    global $controller;
    $controller->status();
});

//Define a "form" route
$f3->route('GET|POST /form', function () {
    global $controller;
    $controller->form();
});

//Run fat free
$f3->run();