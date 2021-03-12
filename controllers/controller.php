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
        global $validator;

        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Get the data from the POST array
            $patronUsername = strtolower(trim($_POST['username']));
            $patronPassword = strtolower(trim($_POST['password']));

            //get login credentials
            require($_SERVER['HOME'] . '/logincredspatrontracker.php');

            //check if username and password are valid
            if ($validator->validUsername($patronUsername, $adminUser)
                && $validator->validPassword($patronPassword, $adminPassword)) {
                //If they are correct
                $_SESSION['loggedin'] = true;
                $this->_f3->reroute('/status');
            } else //Login is not valid -> Set an error in F3 hive
            {
                $this->_f3->set('errors["login"]', "*Incorrect login");
            }
        }

        //Make form sticky
        $this->_f3->set('patronUsername', isset($patronUsername) ? $patronUsername : "");

        //Display a view
        $view = new Template();
        echo $view->render('views/login.html');
    }

    /** Display status page */
    function status()
    {
        //if not logged in, take user to login page
        if (!isset($_SESSION['loggedin'])) {
            //Redirect to login
            $this->_f3->reroute('/');
        }
        //Display a view
        $view = new Template();
        echo $view->render('views/status.html');
    }


    /** Display form page */
    function form()
    {
        global $validator;
        global $dataLayer;
        global $incident;

        //if not logged in, take user to login page
        if (!isset($_SESSION['loggedin'])) {
            //Redirect to login
            $this->_f3->reroute('/');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get the data from the POST array
            $employeeName = trim($_POST['name']);
            $time = $_POST['time'];
            $date = $_POST['date'];
            $employeePosition = trim($_POST['position']);
            $clientMethod = trim($_POST['method']);
            $clientLocation = trim($_POST['location']);
            $locationOther = trim($_POST['locationOther']);
            $clientQuestion = trim($_POST['question']);
            $questionOther = trim($_POST['questionOther']);
            $clientIncidentReport = trim($_POST['incidentReport']);
            $clientIncReportNum = trim($_POST['incidentNum']);
            $comments = trim($_POST['comments']);


            if ($validator->validName($employeeName)) {
                $_SESSION['employeeName'] = $employeeName;
            } else {
                $this->_f3->set("errors[employeeName]", "*Employee name is required and can only contain characters");
            }

            if ($validator->validTime($time)) {
                $incident->setTimeHelped($time);
            } else {
                $this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
            }

            if ($validator->validDate($date)) {
                $incident->setDateHelped($date);
            } else {
                $this->_f3->set("errors[date]", "*Date is required and needs to follow the correct format");
            }

            if ($validator->validPosition($employeePosition)) {
                $incident->setPosition($employeePosition);
            } else {
                $this->_f3->set("errors[employeePosition]", "*Position is required");
            }

            if ($validator->validContactMethod($clientMethod)) {
                $incident->setContactMethod($clientMethod);
            } else {
                $this->_f3->set("errors[clientMethod]", "*Contact method is required");
            }

            if ($validator->validLocation($clientLocation)) {
                $incident->setLocation($clientLocation);
            } else if ($clientLocation == "other") {
                if ($validator->validLocationOther($locationOther)) {
                    $incident->setLocation("");
                    $incident->setLocationOther($locationOther);
                    $dataLayer->addLocation($locationOther);
                } else {
                    $this->_f3->set("errors[otherLocation]", "Other location is required and can only contain 
                        characters");
                }
            } else {
                $this->_f3->set("errors[clientLocation]", "*Location is required");
            }

            if ($validator->validQuestion($clientQuestion)) {
                $incident->setQuestion($clientQuestion);
            } else if ($clientQuestion == "other") {
                if ($validator->validQuestionOther($questionOther)) {
                    $incident->setQuestion("");
                    $incident->setQuestionOther($questionOther);
                    $dataLayer->addQuestion($questionOther);
                } else {
                    $this->_f3->set("errors[otherQuestion]", "Other question is required");
                }

            } else {
                $this->_f3->set("errors[clientQuestion]", "*Question is required");
            }

            if (isset($clientIncidentReport)) {
                $incident->setFiledIncidentReport('yes');

              /*  if ($validator->validIncidentReportNumber($clientIncReportNum)) {
                    $incident->setIncidentReportNum($clientIncidentReport);
                } else {
                    $this->_f3->set("errors['clientIncReportNum']", "*Incident report number must be provided and can 
                    only contain numbers");
                }*/
            } else {
                $incident->setFiledIncidentReport('no');
            }

            if(isset($comments)) {
                $incident->setComments($comments);
            }

            if (empty($this->_f3->get('errors'))) {
                $_SESSION['incident'] = $incident;
                //Redirect to submission page
                $this->_f3->reroute('/submission');
            }
        }

        //get arrays
        $this->_f3->set('questions', $dataLayer->getQuestions());
        $this->_f3->set('locations', $dataLayer->getLocations());
        $this->_f3->set('positions', $dataLayer->getPositions());
        $this->_f3->set('methods', $dataLayer->getContactMethods());
       // $this->_f3->set('incidentReports', $dataLayer->getIncidentReportOptions());

        //make form sticky
        $this->_f3->set('employeeName', isset($employeeName) ? $employeeName : "");
        $this->_f3->set('clientTime', isset($time) ? $time : "");
        $this->_f3->set('clientDate', isset($date) ? $date : "");
        $this->_f3->set('clientQuestion', isset($clientQuestion) ? $clientQuestion : "");
        $this->_f3->set('clientQuestionOther', isset($questionOther) ? $questionOther : "");
        $this->_f3->set('clientLocation', isset($clientLocation) ? $clientLocation : "");
        $this->_f3->set('clientLocationOther', isset($locationOther) ? $locationOther : "");
        $this->_f3->set('employeePosition', isset($employeePosition) ? $employeePosition : "");
        $this->_f3->set('clientMethod', isset($clientMethod) ? $clientMethod : "");
        $this->_f3->set('clientIncidentReport', isset($clientIncidentReport) ? $clientIncidentReport : "");
        $this->_f3->set('clientIncReportNum', isset($clientIncReportNum) ? $clientIncReportNum : "");
        $this->_f3->set('clientComments', isset($comments) ? $comments : "");
        $this->_f3->set('unknown', "unknown");
        $this->_f3->set('other', "other");

        //Display a view
        $view = new Template();
        echo $view->render('views/form.html');
    }

    /** Submission page */
    function submission()
    {
        //Display a view
        $view = new Template();
        echo $view->render('views/submission.html');
    }

    /** Logout */
    function logout()
    {
        session_destroy();

        //Redirect to login
        $this->_f3->reroute('/');
    }

}

