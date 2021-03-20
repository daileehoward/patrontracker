<?php

/**
 * Class Manager creates an object for a manager using the site
 * @author Dana Clemmer, Dailee Howard
 * classes/manager.php
 */
class manager extends employee
{
    private $_workPhone;

    /**
     * Gets work phone
     * @return int
     */
    public function getWorkPhone()
    {
        return $this->_workPhone;
    }

    /**
     * Sets work phone
     * @param int $workPhone
     */
    public function setWorkPhone($workPhone)
    {
        $this->_workPhone = $workPhone;
    }
}