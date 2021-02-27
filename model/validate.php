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
}