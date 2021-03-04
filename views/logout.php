<?php

session_start();
session_destroy();

//Redirect to login
header("location: login.html");


