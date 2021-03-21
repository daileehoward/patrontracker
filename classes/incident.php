<?php
/**
 * Class Incident creates an object for an incident of a patron
 * @author Dana Clemmer, Dailee Howard
 * classes/incident.php
 */
class Incident
{
    private $_incidentId;
    private $_employeeId;
    private $_position;
    private $_dateHelped;
    private $_timeHelped;
    private $_location;
    private $_locationOther;
    private $_question;
    private $_questionOther;
    private $_contactMethod;
    private $_filedIncidentReport;
    private $_incidentReportNum;
    private $_comments;
    private $_submissionTime;

    /**
     * Gets incident ID
     * @return int
     */
    public function getIncidentId()
    {
        return $this->_incidentId;
    }

    /**
     * Sets incident ID
     * @param int $incidentId
     */
    public function setIncidentId($incidentId): void
    {
        $this->_incidentId = $incidentId;
    }

    /**
     * Gets employee ID
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->_employeeId;
    }

    /**
     * Sets employee ID
     * @return int $employeeId
     */
    public function setEmployeeId($employeeId)
    {
        $this->_employeeId = $employeeId;
    }

    /**
     * Gets position
     * @return String
     */
    public function getPosition()
    {
        return $this->_position;
    }

    /**
     * Sets position
     * @param String $position
     */
    public function setPosition($position): void
    {
        $this->_position = $position;
    }

    /**
     * Gets date helped
     * @return String
     */
    public function getDateHelped()
    {
        return $this->_dateHelped;
    }

    /**
     * Sets date helped
     * @param String $dateHelped
     */
    public function setDateHelped($dateHelped): void
    {
        $this->_dateHelped = $dateHelped;
    }

    /**
     * Gets time helped
     * @return String
     */
    public function getTimeHelped()
    {
        return $this->_timeHelped;
    }

    /**
     * Sets time helped
     * @param String $timeHelped
     */
    public function setTimeHelped($timeHelped): void
    {
        $this->_timeHelped = $timeHelped;
    }

    /**
     * Gets location
     * @return String
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * Sets location
     * @param String $location
     */
    public function setLocation($location): void
    {
        $this->_location = $location;
    }

    /**
     * Gets other location
     * @return String
     */
    public function getLocationOther()
    {
        return $this->_locationOther;
    }

    /**
     * Sets other location
     * @param String $locationOther
     */
    public function setLocationOther($locationOther): void
    {
        $this->_locationOther = $locationOther;
    }

    /**
     * Gets question
     * @return String
     */
    public function getQuestion()
    {
        return $this->_question;
    }

    /**
     * Sets question
     * @param String $question
     */
    public function setQuestion($question): void
    {
        $this->_question = $question;
    }

    /**
     * Gets other question
     * @return String
     */
    public function getQuestionOther()
    {
        return $this->_questionOther;
    }

    /**
     * Sets other question
     * @param String $questionOther
     */
    public function setQuestionOther($questionOther): void
    {
        $this->_questionOther = $questionOther;
    }

    /**
     * Gets contact method
     * @return String
     */
    public function getContactMethod()
    {
        return $this->_contactMethod;
    }

    /**
     * Sets contact method
     * @param String $contactMethod
     */
    public function setContactMethod($contactMethod): void
    {
        $this->_contactMethod = $contactMethod;
    }

    /**
     * Gets filed incident report
     * @return String
     */
    public function getFiledIncidentReport()
    {
        return $this->_filedIncidentReport;
    }

    /**
     * sets filed incident report
     * @param String $filedIncidentReport
     */
    public function setFiledIncidentReport($filedIncidentReport): void
    {
        $this->_filedIncidentReport = $filedIncidentReport;
    }

    /**
     * Gets incident report report number
     * @return int
     */
    public function getIncidentReportNum()
    {
        return $this->_incidentReportNum;
    }

    /**
     * Sets incident report number
     * @param int $incidentReportNum
     */
    public function setIncidentReportNum($incidentReportNum): void
    {
        $this->_incidentReportNum = $incidentReportNum;
    }

    /**
     * Gets comments
     * @return String
     */
    public function getComments()
    {
        return $this->_comments;
    }

    /**
     * Sets comments
     * @param String $comments
     */
    public function setComments($comments): void
    {
        $this->_comments = $comments;
    }

    /**
     * Gets submission time
     * @return String
     */
    public function getSubmissionTime()
    {
        return $this->_submissionTime;
    }

    /**
     * Sets submission time
     * @param String $submissionTime
     */
    public function setSubmissionTime($submissionTime): void
    {
        $this->_submissionTime = $submissionTime;
    }

}