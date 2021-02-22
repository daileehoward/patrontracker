<?php

/* model/data-layer.php
 * returns data for app
 *
 */

class DataLayer
{
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
}