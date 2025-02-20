<?php

/* model/database.php
 * Contains SQL Statements and database queries for site
 */
/**
SQL Statements:
CREATE TABLE employees
(
employeeID INT NOT NULL AUTO_INCREMENT,
firstName VARCHAR(30) NOT NULL,
lastName VARCHAR(30) NOT NULL,
username VARCHAR(30) NOT NULL,
userPassword VARCHAR(30) NOT NULL,
employeeEmail VARCHAR(50),
manager BOOLEAN NOT NULL,
workPhoneExtension INT(4),
PRIMARY KEY(employeeID)
);

<!-- Creates the incidents SQL table -->
CREATE TABLE incidents
(
incidentID INT NOT NULL AUTO_INCREMENT,
employeeID INT NOT NULL,
position INT(1) NOT NULL,
dateHelped DATE NOT NULL,
timeHelped TIME(0) NOT NULL,
location VARCHAR(20) NOT NULL,
locationOther VARCHAR(20),
question VARCHAR(30) NOT NULL,
questionOther VARCHAR(30),
contactMethod VARCHAR(20) NOT NULL,
filedIncidentReport VARCHAR(5) NOT NULL,
incidentReportNumber INT(5),
comments VARCHAR(300),
submissionTime DATETIME NOT NULL,
PRIMARY KEY(incidentID),
FOREIGN KEY(employeeID) REFERENCES employees(employeeID)
);

<!-- Creates the dayHistory SQL table -->
CREATE TABLE dayHistory
(
dayDate DATE NOT NULL,
totalIncidents INT(3) NOT NULL,
totalZoomIncidents INT(3) NOT NULL,
totalPhoneIncidents INT(3) NOT NULL,
totalSHD1Incidents INT(3) NOT NULL,
totalSHD2Incidents INT(3) NOT NULL,
totalIncidentsReportsFiled INT(3) NOT NULL,
PRIMARY KEY(dayDate)
);

<!-- Creates manager account -->
INSERT INTO employees (firstName, lastName, username, userPassword, employeeEmail, manager, workPhoneExtension)
VALUES ('Kim', 'Olsen', 'admin', '@dm!n', 'kOlsen@greenriver.edu', 1, 6066);

<!-- Creates employee account -->
INSERT INTO employees (firstName, lastName, username, userPassword, manager, employeeEmail)
VALUES ('Dailee', 'Howard', 'daileehoward', 'greenriver!', 0, 'Dhoward@greenriver.edu');
 */


/**
 * Class Database creates queries for site
 * @author Dana Clemmer, Dailee Howard
 */
class Database
{
    private $_dbh;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    /**
     * query that returns employee associated with passed in username and password
     * @param $username
     * @param $password
     * @return employee row
     */
    function getEmployee($username, $password)
    {
        /* SELECT QUERY WITH FETCH (gets one row) */

        //Define the query
        $sql = "SELECT * FROM employees WHERE username = :employeeUsername AND userPassword = :employeePassword 
                LIMIT 1";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':employeeUsername', $username, PDO::PARAM_STR);
        $statement->bindParam(':employeePassword', $password, PDO::PARAM_STR);

        $statement->execute();

        //Process the result
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getManagerEmail($firstNameManager, $lastNameManager)
    {
        //Define the query
        $sql = "SELECT employeeEmail FROM employees WHERE firstName = :firstNameManager AND 
              lastName = :lastNameManager";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':firstName', $firstNameManager, PDO::PARAM_STR);
        $statement->bindParam(':lastName', $lastNameManager, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * insert query to insert employee into database
     * @param $employee employee object passed in
     */
    function insertEmployee($employee)
    {
        /* INSERT QUERY */

        //Define the query
        $sql = "INSERT INTO employees (firstName, lastName, username, userPassword, employeeEmail) 
                VALUES (:firstName, :lastName, :username, :userPassword, :employeeEmail)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':firstName', $employee->getFirstName(), PDO::PARAM_STR);
        $statement->bindParam(':lastName', $employee->getLastName(), PDO::PARAM_STR);
        $statement->bindParam(':username', $employee->getUsername(), PDO::PARAM_STR);
        $statement->bindParam(':userPassword', $employee->getPassword(), PDO::PARAM_STR);
        $statement->bindParam(':employeeEmail', $employee->getEmail(), PDO::PARAM_STR);

        //Execute
        $statement->execute();
    }

    function insertManager($manager)
    {
        /* INSERT QUERY */

        //Define the query
        $sql = "INSERT INTO employees (firstName, lastName, username, userPassword, employeeEmail, workPhoneExtension) 
                VALUES (:firstName, :lastName, :username, :userPassword, :employeeEmail, :workPhoneExtension)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':firstName', $manager->getFirstName(), PDO::PARAM_STR);
        $statement->bindParam(':lastName', $manager->getLastName(), PDO::PARAM_STR);
        $statement->bindParam(':username', $manager->getUsername(), PDO::PARAM_STR);
        $statement->bindParam(':userPassword', $manager->getPassword(), PDO::PARAM_STR);
        $statement->bindParam(':employeeEmail', $manager->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':workPhoneExtension', $manager->getWorkPhoneExtension(), PDO::PARAM_INT);

        //$manager = $employee instanceof Manager ? 1 : 0;
        //$statement->bindParam(':manager', $manager, PDO::PARAM_BOOL);

        //Execute
        $statement->execute();
    }

    /**
     * query that returns 5 most recent rows from incident
     */
    function getRecentRowsIncident()
    {
        /* SELECT QUERY WITH FETCHALL (gets multiple rows) */

        //Define the query
        $sql = "SELECT * FROM incidents, employees WHERE incidents.employeeID = employees.employeeID ORDER BY incidentID
        DESC LIMIT 5";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Execute the statement
        $statement->execute();

        //Process the result
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getIncidentID($incident)
    {
        $sql = "SELECT incidentID FROM incidents WHERE position = :position, 
                dateHelped = :dateHelped, timeHelped = :timeHelped, location = :location, 
                locationOther = :locationOther, question = :question, questionOther = :questionOther, 
                contactMethod = :contactMethod, filedIncidentReport = :filedIncidentReport, 
                incidentReportNumber = :incidentReportNumber, comments = :comments, submissionTime = :submissionTime";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':position', $incident->getPosition(), PDO::PARAM_INT);
        $statement->bindParam(':dateHelped', $incident->getDateHelped(), PDO::PARAM_STR);
        $statement->bindParam(':timeHelped', $incident->getTimeHelped(), PDO::PARAM_STR);
        $statement->bindParam(':location', $incident->getLocation(), PDO::PARAM_STR);
        $statement->bindParam(':locationOther', $incident->getLocationOther(), PDO::PARAM_STR);
        $statement->bindParam(':question', $incident->getQuestion(), PDO::PARAM_STR);
        $statement->bindParam(':questionOther', $incident->getQuestionOther(), PDO::PARAM_STR);
        $statement->bindParam(':contactMethod', $incident->getContactMethod(), PDO::PARAM_STR);
        $statement->bindParam(':filedIncidentReport', $incident->getFiledIncidentReport(), PDO::PARAM_STR);
        $statement->bindParam(':incidentReportNumber', $incident->getIncidentReportNum(), PDO::PARAM_INT);
        $statement->bindParam(':comments', $incident->getComments(), PDO::PARAM_STR);
        $statement->bindParam(':submissionTime', $incident->getSubmissionTime(), PDO::PARAM_STR);

        //Execute
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * insert query to insert incident into database
     * @param $incident incident object passed in
     */
    function insertIncident($incident)
    {
        /* INSERT QUERY */

        //Define the query
        $sql = "INSERT INTO incidents (employeeID, position, dateHelped, timeHelped, location, locationOther,
               question, questionOther, contactMethod, filedIncidentReport, incidentReportNumber, comments, 
               submissionTime) VALUES (:employeeID, :position, :dateHelped, :timeHelped, :location, :locationOther, 
               :question, :questionOther, :contactMethod, :filedIncidentReport, :incidentReportNumber, :comments, 
               :submissionTime)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':employeeID', $incident->getEmployeeId(), PDO::PARAM_INT);
        $statement->bindParam(':position', $incident->getPosition(), PDO::PARAM_INT);
        $statement->bindParam(':dateHelped', $incident->getDateHelped(), PDO::PARAM_STR);
        $statement->bindParam(':timeHelped', $incident->getTimeHelped(), PDO::PARAM_STR);
        $statement->bindParam(':location', $incident->getLocation(), PDO::PARAM_STR);
        $statement->bindParam(':locationOther', $incident->getLocationOther(), PDO::PARAM_STR);
        $statement->bindParam(':question', $incident->getQuestion(), PDO::PARAM_STR);
        $statement->bindParam(':questionOther', $incident->getQuestionOther(), PDO::PARAM_STR);
        $statement->bindParam(':contactMethod', $incident->getContactMethod(), PDO::PARAM_STR);
        $statement->bindParam(':filedIncidentReport', $incident->getFiledIncidentReport(), PDO::PARAM_STR);
        $statement->bindParam(':incidentReportNumber', $incident->getIncidentReportNum(), PDO::PARAM_INT);
        $statement->bindParam(':comments', $incident->getComments(), PDO::PARAM_STR);
        $statement->bindParam(':submissionTime', $incident->getSubmissionTime(), PDO::PARAM_STR);

        //Execute
        $statement->execute();
    }

    /**
     * Returns row count where row matches passed in specifications
     * @param $selectedDate
     * @param $position
     * @param $startTime
     * @return int
     */
    function getHourHistory($selectedDate, $position, $startTime)
    {
        $sql = "SELECT * FROM incidents WHERE dateHelped = :selectedDate AND position = :position AND 
                 timeHelped LIKE :startTime";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        $timeSelected = $startTime . ":%";

        //Bind the parameters
        $statement->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
        $statement->bindParam(':position', $position, PDO::PARAM_INT);
        $statement->bindParam(':startTime', $timeSelected, PDO::PARAM_STR);

        //Execute
        $statement->execute();

        return $statement->rowCount(PDO::FETCH_ASSOC);
    }

    /**
     * Returns row count where row matches passed in specifications
     * @param $selectedDate
     * @return int
     */
    function getTotalPatronsToday($selectedDate)
    {
        $sql = "SELECT * FROM incidents WHERE dateHelped = :selectedDate";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);

        //Execute
        $statement->execute();

        return $statement->rowCount(PDO::FETCH_ASSOC);
    }

    /**
     * insert query to insert dayHistory into database
     * @param $dayHistory dayHistory object passed in
     */
    function insertNewDayHistory($dayDate)
    {
        /* INSERT QUERY */

        //Define the query
        $sql = "INSERT INTO dayHistory (dayDate, totalIncidents, totalZoomIncidents, totalPhoneIncidents, 
                totalSHD1Incidents, totalSHD2Incidents, totalIncidentsReportsFiled) VALUES (:dayDate, :totalIncidents, 
                :totalZoomIncidents, :totalPhoneIncidents, :totalSHD1Incidents, :totalSHD2Incidents, 
                :totalIncidentsReportsFiled)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        // Empty int parameter
        $intZero = 0;

        //Bind the parameters
        $statement->bindParam(':dayDate', $dayDate, PDO::PARAM_STR);
        $statement->bindParam(':totalIncidents', $intZero, PDO::PARAM_INT);
        $statement->bindParam(':totalZoomIncidents', $intZero, PDO::PARAM_INT);
        $statement->bindParam(':totalPhoneIncidents', $intZero, PDO::PARAM_INT);
        $statement->bindParam(':totalSHD1Incidents', $intZero, PDO::PARAM_INT);
        $statement->bindParam(':totalSHD2Incidents', $intZero, PDO::PARAM_INT);
        $statement->bindParam(':totalIncidentsReportsFiled', $intZero, PDO::PARAM_INT);

        //Execute the statement
        $statement->execute();
    }

    /**
     * update query to increment dayHistory columns
     * @param $dayHistory dayHistory object passed in
     */
    function updateDayHistory($dayHistory)
    {
        /* UPDATE QUERY */

        //Define the query
        $sql = "UPDATE dayHistory SET totalIncidents = :newTotalIncidents,
                      totalZoomIncidents = :newTotalZoomIncidents, totalPhoneIncidents = :newTotalPhoneIncidents, 
                      totalSHD1Incidents = :newTotalSHD1Incidents, totalSHD2Incidents = :newTotalSHD2Incidents,
                      totalIncidentsReportsFiled = :newTotalIncidentsReportsFiled WHERE dayDate = :dayDate";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':newTotalIncidents', $dayHistory->getTotalIncidents(), PDO::PARAM_INT);
        $statement->bindParam(':newTotalZoomIncidents', $dayHistory->getZoomIncidents(), PDO::PARAM_INT);
        $statement->bindParam(':newTotalPhoneIncidents', $dayHistory->getPhoneIncidents(), PDO::PARAM_INT);
        $statement->bindParam(':newTotalSHD1Incidents', $dayHistory->getShd1Incidents(), PDO::PARAM_INT);
        $statement->bindParam(':newTotalSHD2Incidents', $dayHistory->getShd2Incidents(), PDO::PARAM_INT);
        $statement->bindParam(':newTotalIncidentsReportsFiled', $dayHistory->getIncidentReportsFiled(), PDO::PARAM_INT);
        $statement->bindParam(':dayDate', $dayHistory->getDate(), PDO::PARAM_STR);

        //Execute
        $statement->execute();
    }

    /**
     * query that returns a row from dayHistory table
     */
    function getDayHistory($dayDate)
    {
        /* SELECT QUERY WITH FETCH (gets one row) */

        //Define the query
        $sql = "SELECT * FROM dayHistory WHERE dayDate = :dayDate LIMIT 1";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':dayDate', $dayDate, PDO::PARAM_STR);

        //Execute the statement
        $statement->execute();

        //Process the result
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getAveragePatronsPerDay()
    {
        //Define the query
        $sql = "SELECT * FROM incidents";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Execute the statement
        $statement->execute();

        $totalIncidents = $statement->rowCount();
        $totalIncidents = (float)($totalIncidents);

        //Define the query
        $sql = "SELECT * FROM dayHistory";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Execute the statement
        $statement->execute();

        $totalDays = $statement->rowCount();
        $totalDays = (float)($totalDays);

        if ($totalDays != 0) {
            return $totalIncidents / $totalDays;
        } else {
            return 0;
        }
    }

    function getTotalPatronsWeek($dayDate)
    {
        //Define the query
        $sql = "SELECT totalIncidents FROM dayHistory WHERE YEARWEEK(:dayDate) = YEARWEEK(dayDate)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':dayDate', $dayDate, PDO::PARAM_STR);

        //Execute the statement
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $totalPatrons = 0;

        foreach ($results as $result) {
            $totalPatrons += (int)($result['totalIncidents']);
        }

        return $totalPatrons;
    }

    /**
     * query that returns rows from incidents table
     */
    function getIncidents()
    {
        /* SELECT QUERY WITH FETCHALL (gets multiple rows) */

        //Define the query
        $sql = "SELECT * FROM incidents ORDER BY submissionTime";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Execute the statement
        $statement->execute();

        //Process the result
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}