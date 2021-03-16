<?php

//get login credentials
require($_SERVER['HOME'] . '/logincredspatrontracker.php');
//require('../views/includes/logincredspatrontracker.php');

/**
 * Class Validate contains validation functions for site/app
 * @author Dana Clemmer, Dailee Howard
 * model/validate.php
 */
class Validate
{
    private $_dataLayer;

    function __construct($dataLayer)
    {
        $this->_dataLayer = $dataLayer;
    }

    /** validUsername() returns true if username is not empty and
     * equals username in logincredspatrontracker.php
     * @param String $username
     * @return boolean
     */
    function validUsername($username, $adminUser)
    {
        return !empty($username) && $username == $adminUser;
    }

    /** validPassword() returns true if password is not empty and
     * equals password in logincredspatrontracker.php
     * @param String $password
     * @return boolean
     */
    function validPassword($password, $adminPassword)
    {
        return !empty($password) && $password == $adminPassword;
    }

    /**
     * Returns true if name is not empty and contains only letters
     * @param $name
     * @return bool
     */
    function validName($name)
    {
        return !empty($name) && preg_match("/^[a-zA-Z ]+$/", $name)
            || preg_match("/^[a-zA-Z]+ [a-zA-Z]+$/", $name);
    }

    /**
     * Returns true of time is not empty
     * @param $time
     * @return bool
     */
    function validTime($time)
    {
        return !empty($time);
    }

    /**
     * Returns true if date is not empty
     * @param $date
     * @return bool
     */
    function validDate($date)
    {
        return !empty($date);
    }

    /**
     * Returns true if position is not empty
     * @param $position
     * @return bool
     */
    function validPosition($position)
    {
        return !empty($position);
    }

    /**
     * Returns true if contactMethod is not empty and is in array in DataLayer
     * @param $contactMethod
     * @return bool
     */
    function validContactMethod($contactMethod)
    {
        return !empty($contactMethod) and in_array($contactMethod, $this->_dataLayer->getContactMethods());
    }

    /**
     * Returns true if location is not empty and is in array in DataLayer or is "unknown"
     * @param $location
     * @return bool
     */
    function validLocation($location)
    {
        return !empty($location) && in_array($location, $this->_dataLayer->getLocations()) || $location == "unknown";
    }

    /**
     * Returns true if locationOther is not empty and is not in array in DataLayer
     * @param $locationOther
     * @return bool
     */
    function validLocationOther($locationOther)
    {
        return !empty($locationOther) && !in_array($locationOther, $this->_dataLayer->getLocations());
    }

    /**
     * Returns true if question is not empty and is in array in DataLayer
     * @param $question
     * @return bool
     */
    function validQuestion($question)
    {
        return !empty($question) && in_array($question, $this->_dataLayer->getQuestions());
    }

    /**
     * Returns true if questionOther is not empty and is not in array in DataLayer
     * @param $questionOther
     * @return bool
     */
    function validQuestionOther($questionOther)
    {
        return !empty($questionOther) && !in_array($questionOther, $this->_dataLayer->getQuestions());
    }

    /**
     * Returns true if incidentReport is not empty
     * @param $incidentReport
     * @return bool
     */
    function validIncidentReport($incidentReport)
    {
        return !empty($incidentReport);
    }
}