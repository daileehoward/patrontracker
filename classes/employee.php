<?php
/**
 * Class Employee creates an object for an employee using the site
 * @author Dana Clemmer, Dailee Howard
 * classes/employee.php
 */
class Employee
{
    private $_employeeID;
    private $_name;
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
     * Gets name
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets name
     * @param String $name
     */
    public function setName($name): void
    {
        $this->_name = $name;
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