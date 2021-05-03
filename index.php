<?php
/**
 * Controller for site that utilizes the functions in the Controller class
 * @author Dana Clemmer, Dailee Howard
 * index.php
 */

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require files
require_once('vendor/autoload.php');

//Connect to database using PDO
require($_SERVER['DOCUMENT_ROOT'] . '/../config.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Start a session
session_start();

//add classes
$controller = new Controller($f3);
$dataLayer = new DataLayer($dbh);
$validator = new Validate($dataLayer);
$employee = new Employee();
$manager = new Manager();
$incident = new Incident();
$dayHistory = new DayHistory();
$database = new Database($dbh);

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route (login page)
$f3->route('GET|POST /', function () {
    global $controller;
    $controller->login();
});

//Define a "dashboard" route
$f3->route('GET|POST /register', function () {
    global $controller;
    $controller->register();
});

//Define a "dashboard" route
$f3->route('GET|POST /dashboard', function () {
    global $controller;
    $controller->dashboard();
});

//Define a "form" route
$f3->route('GET|POST /form', function () {
    global $controller;
    $controller->form();
});

//Define a "submission" route
$f3->route('GET|POST /submission', function () {
    global $controller;
    $controller->submission();
});

//Define a "logout" route
$f3->route('GET|POST /logout', function () {
    global $controller;
    $controller->logout();
});

//Run fat free
$f3->run();