<?php

/**
 * Class DataLayer returns data for site/app
 * @author Dana Clemmer, Dailee Howard
 * model/data-layer.php
 */

class DataLayer
{
    public $_dbh;
    private $_locationsArray;
    private $_questionsArray;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;

        $this->_locationsArray = array("auburn", "arizona", "bonney lake", "canada", "china", "covington", "delaware",
        "edgewood", "enumclaw", "federal way", "florida", "kent", "korea", "lake tapps", "maple valley", "tennessee",
        "milton", "olympia", "philippines", "port angeles", "puyallup", "renton", "seattle", "stanwood", "south korea",
        "tacoma", "tukwila", "walla walla", "issaquah", "louisiana", "des moines", "myanmar", "vietnam", "michigan",
        "alaska", "coupeville", "bothell", "yelm", "united arab emirates", "white pass", "pacific", "bellevue",
        "buckley", "port townsend", "black diamond", "nevada", "gig harbor", "texas");

        $this->_questionsArray = array("admission issue", "adobe account", "borrowed item", "borrowed laptop 
        troubleshooting", "address change", "canvas troubleshooting", "canvas classes", "connect to advisor", "connect 
        to instructor", "convert pdf to word doc", "employee account locked", "financial aid", "holman library issue",
        "linkedin learning issue", "virtual desktop login", "microsoft office account", "microsoft office download",
        "microsoft troubleshooting", "my greenriver", "noodletools citation", "office of the registrar (formerly 
        enrollment services", "onedrive", "placement testing", "printing through campus", "registration", "respondus 
        lockdown browser", "sexual assault training", "student email (lookup)", "student email (hacked)", "student 
        email (password reset)", "student email (login issue)", "student email (unable to receive emails)", "student 
        email (unable to send emails)", "student id", "student pin", "student transcript", "tlr", "tutoring and 
        resources center", "uploading files to canvas", "video recording", "wifi issue", "zoom audio issue", "covid 
        training", "bookstore", "continuing education", "grc account password reset", "workforce education", "campus 
        housing", "discord", "international programs", "ged program", "counseling services", "wamap", "employee 
        password", "personal printer issue", "nasar", "job application", "criminal justice department", "personal 
        laptop issue");
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
        array_push($this->_locationsArray, $newLocation);
    }

    /** getPositions() returns an array of positions
     *  @return array
     */
    function getPositions()
    {
        return array(1, 2);
    }

    /** getContactMethods() returns an array of contact methods
     *  @return array
     */
    function getContactMethods()
    {
        return array("zoom", "phone");
    }

    function getSessionHourNames()
    {
        return array('hour8-9History', 'hour9-10History', 'hour10-11History', 'hour11-12History', 'hour12-13History',
            'hour13-14History', 'hour14-15History', 'hour15-16History', 'hour16-17History', 'hour17-18History',
            'hour18-19History');
    }
}