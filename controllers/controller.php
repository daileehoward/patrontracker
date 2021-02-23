<?php

//  controllers/controller.php

class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    /** Display login page */
    function login()
    {
        //Display a view
        $view = new Template();
        echo $view->render('views/login.html');
    }

    /** Display status page */
    function status()
    {
        //Display a view
        $view = new Template();
        echo $view->render('views/status.html');
    }


    /** Display form page */
    function form()
    {
        global $dataLayer;

        //Get the data from the POST array
        $userQuestion = $_POST['question'];
        $questionOther = $_POST['questionOther'];
        $userLocation = $_POST['location'];
        $locationOther = $_POST['locationOther'];
        $position = $_POST['position'];
        $userMethod = $_POST['method'];
        $userIncidentReport = $_POST['incidentReport'];
        $userIncReportNum = $_POST['incidentNum'];
        $comments = $_POST['comments'];

        //get arrays
        $this->_f3->set('questions', $dataLayer->getQuestions());
        $this->_f3->set('locations', $dataLayer->getLocations());
        $this->_f3->set('positions', $dataLayer->getPositions());
        $this->_f3->set('methods', $dataLayer->getContactMethods());
        $this->_f3->set('incidentReports', $dataLayer->getIncidentReportOptions());

        //make form sticky
        $this->_f3->set('userQuestion', isset($userQuestion) ? $userQuestion : "");
        $this->_f3->set('userQuestionOther', isset($questionOther) ? $questionOther : "");
        $this->_f3->set('userLocation', isset($userLocation) ? $userLocation : "");
        $this->_f3->set('userLocationOther', isset($locationOther) ? $locationOther : "");
        $this->_f3->set('userPosition', isset($position) ? $position : "");
        $this->_f3->set('userMethod', isset($userMethod) ? $userMethod : "");
        $this->_f3->set('userIncidentReport', isset($userIncidentReport) ? $userIncidentReport : "");
        $this->_f3->set('userIncReportNum', isset($userIncReportNum) ? $userIncReportNum : "");
        $this->_f3->set('userComments', isset($comments) ? $comments : "");

        //Display a view
        $view = new Template();
        echo $view->render('views/form.html');
    }

}
