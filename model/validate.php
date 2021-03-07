<?php
/* model/validate.php
 * Contains validation functions for Food app
 *
 */

//get login credentials
require($_SERVER['HOME'] . '/logincredspatrontracker.php');
//require('../views/includes/logincredspatrontracker.php');

class Validate
{
 /*   private $_dataLayer;

    function __construct($dataLayer)
    {
        $this->_dataLayer = $dataLayer;
    }*/

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

    function validName($name)
    {
        return !empty($name) && preg_match("/^[a-zA-Z]+ [a-zA-Z]+$/", $name);
    }

    function validTime($time)
    {
        return !empty($time);
    }

    function validDate($data)
    {
        return !empty($data);
    }

    function validPosition($position)
    {
        return !empty($position);
    }

    function validContactMethod($contactMethod)
    {
        return !empty($contactMethod);
    }

    function validLocation($location)
    {
        return !empty($location);
    }

    function validLocationOther($locationOther)
    {
        return !empty($locationOther);
    }

    function validQuestion($question)
    {
        return !empty($question);
    }

    function validQuestionOther($questionOther)
    {
        return !empty($questionOther);
    }

    function validIncidentReport($incidentReport)
    {
        return !empty($incidentReport);
    }

    function validIncidentReportNumber($incidentReportNumber)
    {
        return !empty($incidentReportNumber);
    }
}