<?php

class Employee
{
    private $_employeeID;
    private $_name;
    private $_email;
    private $_username;
    private $_password;

    /**
     * @return int
     */
    public function getEmployeeID()
    {
        return $this->_employeeID;
    }

    /**
     * @param int $employeeID
     */
    public function setEmployeeID($employeeID): void
    {
        $this->_employeeID = $employeeID;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param String $name
     */
    public function setName($name): void
    {
        $this->_name = $name;
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return String
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param String $username
     */
    public function setUsername($username): void
    {
        $this->_username = $username;
    }

    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param String $password
     */
    public function setPassword($password): void
    {
        $this->_password = $password;
    }


}