<?php

/**
 * Class Manager creates an object for a manager using the site
 * @author Dana Clemmer, Dailee Howard
 * @author Dana Clemmer, Dailee Howard
 * classes/manager.php
 */
class Manager extends Employee
{
    private $_workPhoneExtension;

    /**
     * Gets work phone extension
     * @return int
     */
    public function getWorkPhoneExtension()
    {
        return $this->_workPhoneExtension;
    }

    /**
     * Sets work phone extension
     * @param int $workPhoneExtension
     */
    public function setWorkPhoneExtension($workPhoneExtension)
    {
        $this->_workPhoneExtension = $workPhoneExtension;
    }
}