<?php

class Patron
{
    private $_patronId;
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
     * @return int
     */
    public function getPatronId()
    {
        return $this->_patronId;
    }

    /**
     * @param int $patronId
     */
    public function setPatronId($patronId): void
    {
        $this->_patronId = $patronId;
    }

    /**
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->_employeeId;
    }

    /**
     * @return String
     */
    public function getPosition()
    {
        return $this->_position;
    }

    /**
     * @param String $position
     */
    public function setPosition($position): void
    {
        $this->_position = $position;
    }

    /**
     * @return String
     */
    public function getDateHelped()
    {
        return $this->_dateHelped;
    }

    /**
     * @param String $dateHelped
     */
    public function setDateHelped($dateHelped): void
    {
        $this->_dateHelped = $dateHelped;
    }

    /**
     * @return String
     */
    public function getTimeHelped()
    {
        return $this->_timeHelped;
    }

    /**
     * @param String $timeHelped
     */
    public function setTimeHelped($timeHelped): void
    {
        $this->_timeHelped = $timeHelped;
    }

    /**
     * @return String
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * @param String $location
     */
    public function setLocation($location): void
    {
        $this->_location = $location;
    }

    /**
     * @return String
     */
    public function getLocationOther()
    {
        return $this->_locationOther;
    }

    /**
     * @param String $locationOther
     */
    public function setLocationOther($locationOther): void
    {
        $this->_locationOther = $locationOther;
    }

    /**
     * @return String
     */
    public function getQuestion()
    {
        return $this->_question;
    }

    /**
     * @param String $question
     */
    public function setQuestion($question): void
    {
        $this->_question = $question;
    }

    /**
     * @return String
     */
    public function getQuestionOther()
    {
        return $this->_questionOther;
    }

    /**
     * @param String $questionOther
     */
    public function setQuestionOther($questionOther): void
    {
        $this->_questionOther = $questionOther;
    }

    /**
     * @return String
     */
    public function getContactMethod()
    {
        return $this->_contactMethod;
    }

    /**
     * @param String $contactMethod
     */
    public function setContactMethod($contactMethod): void
    {
        $this->_contactMethod = $contactMethod;
    }

    /**
     * @return String
     */
    public function getFiledIncidentReport()
    {
        return $this->_filedIncidentReport;
    }

    /**
     * @param String $filedIncidentReport
     */
    public function setFiledIncidentReport($filedIncidentReport): void
    {
        $this->_filedIncidentReport = $filedIncidentReport;
    }

    /**
     * @return int
     */
    public function getIncidentReportNum()
    {
        return $this->_incidentReportNum;
    }

    /**
     * @param int $incidentReportNum
     */
    public function setIncidentReportNum($incidentReportNum): void
    {
        $this->_incidentReportNum = $incidentReportNum;
    }

    /**
     * @return String
     */
    public function getComments()
    {
        return $this->_comments;
    }

    /**
     * @param String $comments
     */
    public function setComments($comments): void
    {
        $this->_comments = $comments;
    }

    /**
     * @return String
     */
    public function getSubmissionTime()
    {
        return $this->_submissionTime;
    }

    /**
     * @param String $submissionTime
     */
    public function setSubmissionTime($submissionTime): void
    {
        $this->_submissionTime = $submissionTime;
    }

}