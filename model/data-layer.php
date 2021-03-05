<?php

/* model/data-layer.php
 * returns data for app
 *
 */

class DataLayer
{
    private $_dbh;
    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    /** getQuestions() returns an array of questions
     *  @return array
     */
    function getQuestions()
    {
        return array("q1", "q2", "q3");
    }

    /** getLocations() returns an array of locations
     *  @return array
     */
    function getLocations()
    {
        return array("l1", "l2", "l3");
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