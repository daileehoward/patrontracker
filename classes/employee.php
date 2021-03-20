<?php

/**
 * Class Employee creates an object for an employee using the site
 * @author Dana Clemmer, Dailee Howard
 * classes/employee.php
 */
class Employee
{
    private $_employeeID;
    private $_firstName;
    private $_lastName;
    private $_email;
    private $_username;
    private $_password;

    /**
     * Gets employee ID
     * @return int
     */
    public function getEmployeeID()
    {
        return $this->_employeeID;
    }

    /**
     * Set employee ID
     * @param int $employeeID
     */
    public function setEmployeeID($employeeID): void
    {
        $this->_employeeID = $employeeID;
    }

    /**
     * Gets first name
     * @return String
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * Sets first name
     * @param String $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->_firstName = $firstName;
    }

    /**
     * Gets last name
     * @return String
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * Sets last name
     * @param String $lastName
     */
    public function setLastName($lastName): void
    {
        $this->_lastName = $lastName;
    }

    /**
     * Gets email
     * @return String
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets email
     * @return String
     */
    public function setEmail($email) : void
    {
        $this->_email = $email;
    }

    /**
     * Gets username
     * @return String
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * Sets username
     * @param String $username
     */
    public function setUsername($username): void
    {
        $this->_username = $username;
    }

    /**
     * Gets password
     * @return String
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Sets password
     * @param String $password
     */
    public function setPassword($password): void
    {
        $this->_password = $password;
    }


}