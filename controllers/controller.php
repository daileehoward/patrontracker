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

                    $_SESSION['employee'] = $manager;
                }

                $this->_f3->reroute('/status');
            } else {
                //Login is not valid -> Set an error in F3 hive
                $this->_f3->set('errors["login"]', "*Incorrect username and/or password");
            }
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
        global $dataLayer;

        //if not logged in, take user to login page
        if (is_null($_SESSION['employee'])) {
            //Redirect to login
            $this->_f3->reroute('/');
        }

        $currentDate = new DateTime("now", new DateTimeZone('America/Los_Angeles'));
        $currentDate = $currentDate->format('F j, Y');
        $_SESSION['currentDate'] = $currentDate;
        //$_SESSION['dayHistory'] = $database->getDayHistory(date('YYYY-mm-dd'));

        $currentDateSQL = new DateTime("now", new DateTimeZone('America/Los_Angeles'));
        $currentDateSQL = $currentDateSQL->format('Y-m-d');

        $startOfDay = 8;
        $endOfDay = 19;
        $sessionHourNames = $dataLayer->getSessionHourNames();
        $sessionHourNamesIndex = 0;

        for ($startHour = $startOfDay; $startHour < $endOfDay; $startHour++) {
            $sessionName = $sessionHourNames[$sessionHourNamesIndex];
            if ($startHour <= 9) {
                $hourHistorySHD1 =
                    $database->getHourHistory($currentDateSQL, 1, ("0" . (string)($startHour)));
                $this->_f3->set($sessionName . 'SHD1', $hourHistorySHD1);
                $hourHistorySHD2 =
                    $database->getHourHistory($currentDateSQL, 2, ("0" . (string)($startHour)));
                $this->_f3->set($sessionName . 'SHD2', $hourHistorySHD2);
            }
            $hourHistorySHD1 =
                $database->getHourHistory($currentDateSQL, 1, ((string)($startHour)));
            $this->_f3->set($sessionName . 'SHD1', $hourHistorySHD1);
            $hourHistorySHD2 =
                $database->getHourHistory($currentDateSQL, 2, ((string)($startHour)));
            $this->_f3->set($sessionName . 'SHD2', $hourHistorySHD2);

            $sessionHourNamesIndex++;
        }

        $this->_f3->set('incidents', $database->getIncidents());
        //$this->_f3->set('dayHistory', $database->getDayHistory(date('YYYY-mm-dd')));
        //$this->_f3->set('notifications', $_SESSION['notifications']);
        $this->_f3->set('recentRows', $database->getRecentRowsIncident());
        $totalPatronsToday = $database->getTotalPatronsToday($currentDateSQL);
        $this->_f3->set('totalPatronsToday', $totalPatronsToday);
        $this->_f3->set('avgPatronsHour', number_format((float)$totalPatronsToday / 11, 1, '.', ''));
        $averagePatrons = $database->getAveragePatronsPerDay();
        $this->_f3->set('avgPatrons', $averagePatrons);
        $totalPatronsWeek = $database->getTotalPatronsWeek($currentDateSQL);
        $this->_f3->set('totalPatronsWeek', $totalPatronsWeek);

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
        global $dayHistory;

        if (is_null($_SESSION['employee'])) {
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


            if ($validator->verifiedAccountName($employeeName, ($_SESSION['employee']->getFirstName() . " " .
                $_SESSION['employee']->getLastName()))) {
                $incident->setEmployeeId($_SESSION['employee']->getEmployeeID());
            } else {
                $this->_f3->set("errors[employeeName]", "*Employee name is required and must match the name on your 
                    account");
            }

            if ($validator->validTime($time)) {
                $time = (string)$time;
                //$time = $time . ":00";
                //$time = (int)date("H",strtotime($time));
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
                $dayHistory->setDate($date);
            } else {
                $this->_f3->set("errors[date]", "*Date is required and needs to follow the correct format");
            }

            if ($validator->validPosition($employeePosition)) {
                $incident->setPosition($employeePosition);
                //shd1
                if ($employeePosition == 1) {
                    if (is_null($dayHistory->getShd1Incidents())) {
                        $dayHistory->setShd1Incidents(1);
                    } else {
                        $dayHistory->setShd1Incidents($dayHistory->getShd1Incidents() + 1);
                    }
                    if (is_null($dayHistory->getShd2Incidents())) {
                        $dayHistory->setShd2Incidents(0);
                    }
                    if (is_null($dayHistory->getTotalIncidents())) {
                        $dayHistory->setTotalIncidents(1);
                    } else {
                        $dayHistory->setTotalIncidents($dayHistory->getTotalIncidents() + 1);
                    }
                } //shd2
                else if ($employeePosition == 2) {
                    if (is_null($dayHistory->getShd2Incidents())) {
                        $dayHistory->setShd2Incidents(1);
                    } else {
                        $dayHistory->setShd2Incidents($dayHistory->getShd2Incidents() + 1);
                    }
                    if (is_null($dayHistory->getShd1Incidents())) {
                        $dayHistory->setShd1Incidents(0);
                    }
                    if (is_null($dayHistory->getTotalIncidents())) {
                        $dayHistory->setTotalIncidents(1);
                    } else {
                        $dayHistory->setTotalIncidents($dayHistory->getTotalIncidents() + 1);
                    }
                }
            } else {
                $this->_f3->set("errors[employeePosition]", "*Position is required");
            }

            if ($validator->validContactMethod($clientMethod)) {
                $incident->setContactMethod($clientMethod);

                if ($clientMethod == "zoom") {
                    if (is_null($dayHistory->getZoomIncidents())) {
                        $dayHistory->setZoomIncidents(1);
                    } else {
                        $dayHistory->setZoomIncidents($dayHistory->getZoomIncidents() + 1);
                    }
                    if (is_null($dayHistory->getPhoneIncidents())) {
                        $dayHistory->setPhoneIncidents(0);
                    }
                } else if ($clientMethod == "phone") {
                    if (is_null($dayHistory->getPhoneIncidents())) {
                        $dayHistory->setPhoneIncidents(1);
                    } else {
                        $dayHistory->setPhoneIncidents($dayHistory->getPhoneIncidents() + 1);
                    }
                    if (is_null($dayHistory->getZoomIncidents())) {
                        $dayHistory->setZoomIncidents(0);
                    }
                }
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
                } else if (!($validator->validLocationOther($locationOther))) {
                    $incident->setLocation($locationOther);
                    $incident->setLocationOther("");
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
                } else if (!($validator->validQuestionOther($questionOther))) {
                    $incident->setQuestion($questionOther);
                    $incident->setQuestionOther("");
                } else {
                    $this->_f3->set("errors[otherQuestion]", "Other question is required");
                }
            } else {
                $this->_f3->set("errors[clientQuestion]", "*Question is required");
            }

            if (!empty($clientIncidentReport)) {
                $incident->setFiledIncidentReport("Yes");

                if (is_null($dayHistory->getIncidentReportsFiled())) {
                    $dayHistory->setIncidentReportsFiled(1);
                } else {
                    $dayHistory->setIncidentReportsFiled($dayHistory->getIncidentReportsFiled() + 1);
                }

                if ($validator->validIncidentReport($clientIncReportNum)) {
                    $clientIncReportNum = (int)($clientIncReportNum);
                    $incident->setIncidentReportNum($clientIncReportNum);
                } else {
                    $this->_f3->set("errors[clientIncReportNum]", "*Incident report number can only contain numbers");
                }
            } else {
                $incident->setFiledIncidentReport("No");

                if (is_null($dayHistory->getIncidentReportsFiled())) {
                    $dayHistory->setIncidentReportsFiled(0);
                } else {
                    $dayHistory->setIncidentReportsFiled($dayHistory->getIncidentReportsFiled());
                }
            }

            if (isset($comments)) {
                $incident->setComments($comments);
            }

            if (empty($this->_f3->get('errors'))) {
                $submissionTime = new DateTime("now", new DateTimeZone('America/Los_Angeles'));
                $incident->setSubmissionTime((string)($submissionTime->format('Y-m-d H:i:s')));

                $database->insertIncident($incident);
                $_SESSION['incident'] = $incident;

                $database->insertDayHistory($dayHistory);
                $database->updateDayHistory($dayHistory, $_SESSION['currentDate']);


                /* $_SESSION['notifications'] = $_SESSION['employee']->getFirstName() . " " . $_SESSION['employee']->getLastName()
                     . " submitted a form at " . date("g:i a", strtotime($incident->getSubmissionTime()))
                 . " on " . date("M d, Y", strtotime($incident->getSubmissionTime()));*/


                $_SESSION['dayHistory'] = $dayHistory;

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
        //var_dump($_SESSION);

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

