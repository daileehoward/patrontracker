<?php

/* model/data-layer.php
 * returns data for app
 *
 */

class DataLayer
{
    private $_dbh;
    private $_locationsArray;
    private $_questionsArray;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;
        $this->_locationsArray = array("admission issue", "adobe account", "borrow item", "borrowed laptop troubleshooting");
        $this->_questionsArray = array("2", "l");
    }

    /** getQuestions() returns an array of questions
     *  @return array
     */
    function getQuestions()
    {
        return $this->_questionsArray;
    }

    function addQuestion($newQuestion)
    {
        array_push($this->_questionsArray, $newQuestion);
    }

    /** getLocations() returns an array of locations
     *  @return array
     */
    function getLocations()
    {
        return $this->_locationsArray;
    }

    function addLocation($newLocation)
    {
        array_push($this->_locationsArray);
    }

    /** getPositions() returns an array of positions
     *  @return array
     */
    function getPositions()
    {
        return array("SHD-1", "SHD-2");
    }

    /** getContactMethods() returns an array of contact methods
     *  @return array
     */
    function getContactMethods()
    {
        return array("zoom", "phone");
    }

    /** getIncidentReportOptions() returns an array of incident report options
     *  @return array
     */
    function getIncidentReportOptions()
    {
        return array("yes", "no");
    }
}