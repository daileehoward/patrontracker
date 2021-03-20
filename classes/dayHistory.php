<?php

/**
 * Class DaySchedule creates an object for a specified day on the site
 * @author Dana Clemmer, Dailee Howard
 * classes/dayHistory.php
 */
class DayHistory
{
    private $_date;
    private $_totalIncidents;
    private $_zoomIncidents;
    private $_phoneIncidents;
    private $_shd1Incidents;
    private $_shd2Incidents;
    private $_incidentReportsFiled;

    /**
     * Gets the date of that day
     * @return int
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * Sets the date of that day
     * @param int $date
     */
    public function setDate($date): void
    {
        $this->_date = $date;
    }

    /**
     * Get the total incidents of that day
     * @return int
     */
    public function getTotalIncidents()
    {
        return $this->_totalIncidents;
    }

    /**
     * Set the total incidents for that day
     * @param int $totalIncidents
     */
    public function setTotalIncidents($totalIncidents): void
    {
        $this->_totalIncidents = $totalIncidents;
    }

    /**
     * Get the total number of Zoom incidents for that day
     * @return int
     */
    public function getZoomIncidents()
    {
        return $this->_zoomIncidents;
    }

    /**
     * Set the total number of Zoom incidents for that day
     * @param int $zoomIncidents
     */
    public function setZoomIncidents($zoomIncidents): void
    {
        $this->_zoomIncidents = $zoomIncidents;
    }

    /**
     * Get the total number of phone incidents for that day
     * @return int
     */
    public function getPhoneIncidents()
    {
        return $this->_phoneIncidents;
    }

    /**
     * Set the total number of phone incidents for that day
     * @param int $phoneIncidents
     */
    public function setPhoneIncidents($phoneIncidents): void
    {
        $this->_phoneIncidents = $phoneIncidents;
    }

    /**
     * Get the total number of incidents handled by SHD-1 on that day
     * @return int
     */
    public function getShd1Incidents()
    {
        return $this->_shd1Incidents;
    }

    /**
     * Set the total number of incidents handled by SHD-1 on that day
     * @param int $shd1Incidents
     */
    public function setShd1Incidents($shd1Incidents): void
    {
        $this->_shd1Incidents = $shd1Incidents;
    }

    /**
     * Get the total number of incidents handled by SHD-2 on that day
     * @return int
     */
    public function getShd2Incidents()
    {
        return $this->_shd2Incidents;
    }

    /**
     * Set the total number of incidents handled by SHD-2 on that day
     * @param int $shd2Incidents
     */
    public function setShd2Incidents($shd2Incidents): void
    {
        $this->_shd2Incidents = $shd2Incidents;
    }

    /**
     * Gets the total number of incident reports filed on that day
     * @return int
     */
    public function getIncidentReportsFiled()
    {
        return $this->_incidentReportsFiled;
    }

    /**
     * Sets the total number of incident reports filed on that day
     * @param int $incidentReportsFiled
     */
    public function setIncidentReportsFiled($incidentReportsFiled): void
    {
        $this->_incidentReportsFiled = $incidentReportsFiled;
    }
}