<?php
/**
 * Class Controller for site
 * @author Dana Clemmer, Dailee Howard
 * controllers/controller.php
 */
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
        global $employee;
        global $manager;
        global $database;

        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get the data from the POST array
            $employeeUsername = trim($_POST['username']);
            $employeePassword = trim($_POST['password']);

            //get employee associated with input username and password using query from Database class
            if ($database->getEmployee($employeeUsername, $employeePassword)) {
                //Login is valid -> Store the employee data to a class and proceed to the Status page
                $employeeAccountRow = $database->getEmployee($employeeUsername, $employeePassword);

                if (is_null($employeeAccountRow['workPhoneExtension'])) {
                    $employee->setEmployeeID($employeeAccountRow['employeeID']);
                    $employee->setFirstName($employeeAccountRow['firstName']);
                    $employee->setLastName($employeeAccountRow['lastName']);
                    $employee->setEmail($employeeAccountRow['username']);
                    $employee->setUsername($employeeAccountRow['userPassword']);
                    $employee->setPassword($employeeAccountRow['employeeEmail']);

                    $_SESSION['employee'] = $employee;
                } else {
                    $manager->setEmployeeID($employeeAccountRow['employeeID']);
                    $manager->setFirstName($employeeAccountRow['firstName']);
                    $manager->setLastName($employeeAccountRow['lastName']);
                    $manager->setEmail($employeeAccountRow['username']);
                    $manager->setUsername($employeeAccountRow['userPassword']);
                    $manager->setPassword($employeeAccountRow['employeeEmail']);
                    $manager->setWorkPhoneExtension($employeeAccountRow['workPhoneExtension']);

                    $_SESSION['manager'] = $manager;
                }

                $this->_f3->reroute('/status');
            } else {
                //Login is not valid -> Set an error in F3 hive
                $this->_f3->set('errors["login"]', "*Incorrect username and/or password");
            }

            /*
            //get login credentials
            //require($_SERVER['HOME'] . '/logincredspatrontracker.php');

            //check if username and password are valid
            if ($validator->validUsername($employeeUsername, $adminUser)
                && $validator->validPassword($employeePassword, $adminPassword)) {
                //If they are correct
                $_SESSION['loggedin'] = true;
                $this->_f3->reroute('/status');
            } else //Login is not valid -> Set an error in F3 hive
            {
                $this->_f3->set('errors["login"]', "*Incorrect login");
            }
            */
        }

        //Make form sticky
        $this->_f3->set('employeeUsername', isset($employeeUsername) ? $employeeUsername : "");

        //Display a view
        $view = new Template();
        echo $view->render('views/login.html');
    }

    /** Display status page */
    function status()
    {
        global $database;

        //if not logged in, take user to login page
        if (is_null($_SESSION['employee']) && is_null($_SESSION['manager'])) {
            //Redirect to login
            $this->_f3->reroute('/');
        }
        /*
        //if not logged in, take user to login page
        if (!isset($_SESSION['loggedin'])) {
            //Redirect to login
            $this->_f3->reroute('/');
        }
        */

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
        global $database;

        if (is_null($_SESSION['employee']) && is_null($_SESSION['manager'])) {
            //Redirect to login
            $this->_f3->reroute('/');
        }

        /*
        //if not logged in, take user to login page
        if (!isset($_SESSION['loggedin'])) {
            //Redirect to login
            $this->_f3->reroute('/');
        }
        */

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

            if (is_null($_SESSION['manager'])) {
                if ($validator->verifiedAccountName($employeeName, ($_SESSION['employee']->getFirstName() . " " .
                $_SESSION['employee']->getLastName()))) {
                    $incident->setEmployeeId($_SESSION['employee']->getEmployeeID());
                } else {
                    $this->_f3->set("errors[employeeName]", "*Employee name is required and must match the name on your 
                    account");
                }
            } else {
                if ($validator->verifiedAccountName($employeeName, ($_SESSION['manager']->getFirstName() . " " .
                    $_SESSION['manager']->getLastName()))) {
                    $incident->setEmployeeId($_SESSION['manager']->getEmployeeID());
                } else {
                    $this->_f3->set("errors[employeeName]", "*Employee name is required and must match the name on your 
                    account");
                }
            }

            if ($validator->validTime($time)) {
                $time = (string)$time;

                $incident->setTimeHelped($time);
            } else {
                $this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
            }

            if ($validator->validDate($date)) {
                $date = (string)$date;
                $date = str_replace("/", "-", $date);

                $date = new DateTime($date);
                $date = $date->format('Y-m-d');

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

            if (!empty($clientIncidentReport)) {
                $incident->setFiledIncidentReport(1);

                if ($validator->validIncidentReport($clientIncReportNum)) {
                    $clientIncReportNum = (int)($clientIncReportNum);
                    $incident->setIncidentReportNum($clientIncReportNum);
                } else {
                    $this->_f3->set("errors[clientIncReportNum]", "*Incident report number can only contain numbers");
                }
            } else {
                $incident->setFiledIncidentReport(0);
            }

            if(isset($comments)) {
                $incident->setComments($comments);
            }

            if (empty($this->_f3->get('errors'))) {
                date_default_timezone_set("America/Los_Angeles");
                $incident->setSubmissionTime(date('H:i:s'));

                $database->insertIncident($incident);
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
        session_start();
        session_destroy();

        //Redirect to login
        $this->_f3->reroute('/');
    }

}

