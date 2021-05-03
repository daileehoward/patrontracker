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

            $employeePasswordHashed = password_hash($employeePassword, PASSWORD_DEFAULT);

            //get employee associated with input username and password using query from Database class
            if ($database->getEmployee($employeeUsername, $employeePasswordHashed)) {
                //Login is valid -> Store the employee data to a class and proceed to the dashboard page
                $employeeAccountRow = $database->getEmployee($employeeUsername, $employeePasswordHashed);

                if (password_verify($employeePasswordHashed, $employee->getPassword())) {
                    if (is_null($employeeAccountRow['workPhoneExtension'])) {
                        $employee->setEmployeeID($employeeAccountRow['employeeID']);
                        $employee->setFirstName($employeeAccountRow['firstName']);
                        $employee->setLastName($employeeAccountRow['lastName']);
                        $employee->setEmail($employeeAccountRow['employeeEmail']);
                        $employee->setUsername($employeeAccountRow['username']);
                        $employee->setPassword($employeeAccountRow['userPassword']);

                        $_SESSION['employee'] = $employee;
                    } else {
                        $manager->setEmployeeID($employeeAccountRow['employeeID']);
                        $manager->setFirstName($employeeAccountRow['firstName']);
                        $manager->setLastName($employeeAccountRow['lastName']);
                        $manager->setEmail($employeeAccountRow['employeeEmail']);
                        $manager->setUsername($employeeAccountRow['userPassword']);
                        $manager->setPassword($employeeAccountRow['userPassword']);
                        $manager->setWorkPhoneExtension($employeeAccountRow['workPhoneExtension']);

                        $_SESSION['employee'] = $manager;
                    }

                    $this->_f3->reroute('/dashboard');
                } else {
                    //Login is not valid -> Set an error in F3 hive
                    $this->_f3->set('errors["login"]', "*Incorrect password");
                }
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

    /** Display dashboard page */
    function register()
    {
        global $database;
        global $dataLayer;
        global $validator;
        global $employee;
        global $manager;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get the data from the POST array
            $employeeFirstName = trim($_POST['firstName']);
            $employeeLastName = trim($_POST['lastName']);
            $employeeEmail = trim($_POST['email']);
            $employeeUsername = trim($_POST['username']);
            $employeePassword = trim($_POST['password']);

            if ($_POST['manager']) {
                $managerExtension = trim($_POST['managerExtension']);

                if ($validator->validExtension($managerExtension)) {
                    $manager->setWorkPhoneExtension($managerExtension);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validName($employeeFirstName)) {
                    $manager->setFirstName($employeeFirstName);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validName($employeeLastName)) {
                    $manager->setLastName($employeeLastName);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validEmail($employeeEmail)) {
                    $manager->setEmail($employeeEmail);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validString($employeeUsername)) {
                    $manager->setUsername($employeeUsername);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validString($employeePassword)) {
                    $employeePasswordHashed = password_hash($employeePassword, PASSWORD_DEFAULT);
                    $manager->setPassword($employeePasswordHashed);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }
            } else {
                if ($validator->validName($employeeFirstName)) {
                    $employee->setFirstName($employeeFirstName);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validName($employeeLastName)) {
                    $employee->setLastName($employeeLastName);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validEmail($employeeEmail)) {
                    $employee->setEmail($employeeEmail);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validString($employeeUsername)) {
                    $employee->setUsername($employeeUsername);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }

                if ($validator->validString($employeePassword)) {
                    $employeePasswordHashed = password_hash($employeePassword, PASSWORD_DEFAULT);
                    $employee->setPassword($employeePasswordHashed);
                } else {
                    //$this->_f3->set("errors[time]", "*Time is required and needs to follow the correct format");
                }
            }

            if (empty($this->_f3->get('errors'))) {
                if ($employee->getUsername()) {
                    $database->insertEmployee($employee);
                } else {
                    $database->insertManager($manager);
                }

                // TODO If work email matches approved ones in database, create account
                // TODO Look into valid email regex code
                // TODO Set proper errors

                //Redirect to login page
                $this->_f3->reroute('/');
            }
        }

        //Display a view
        $view = new Template();
        echo $view->render('views/register.html');
    }

    /** Display dashboard page */
    function dashboard()
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

        //Stores five most recent incidents in Session array
        $recentRows = $database->getRecentRowsIncident();

        for ($i = 0; $i < sizeof($recentRows); $i++) {
            $originalSubmissionTime = $recentRows[$i]['submissionTime'];
            $submission = explode(" ", $originalSubmissionTime);
            $recentRows[$i]['submissionTime'] = array($submission[0], $submission[1]);

            $submissionDate = $submission[0];
            $submissionDate = new DateTime($submissionDate);
            $submissionDate = $submissionDate->format('n/d');

            $recentRows[$i]['submissionTime'][0] = $submissionDate;

            $submissionTime = $submission[1];
            $submissionTime = explode(":", $submissionTime);
            $newSubmissionTime = new DateTime($submissionTime[0] . ":" . $submissionTime[1]);
            $newSubmissionTime = $newSubmissionTime->format('g:ia');

            $recentRows[$i]['submissionTime'][1] = $newSubmissionTime;
        }

        $this->_f3->set('recentRows', $recentRows);

        $totalPatronsToday = $database->getTotalPatronsToday($currentDateSQL);
        $this->_f3->set('totalPatronsToday', $totalPatronsToday);
        $this->_f3->set('avgPatronsHour', number_format((float)
            $totalPatronsToday / 11, 1, '.', ''));
        $averagePatrons = $database->getAveragePatronsPerDay();
        $this->_f3->set('avgPatrons', number_format((float)
        $averagePatrons, 1, '.', ''));
        $totalPatronsWeek = $database->getTotalPatronsWeek($currentDateSQL);
        $this->_f3->set('totalPatronsWeek', $totalPatronsWeek);

        //Display a view
        $view = new Template();
        echo $view->render('views/dashboard.html');
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

                $originalDayHistory = $database->getDayHistory($date);

                if (empty($originalDayHistory)) {
                    $database->insertNewDayHistory($date);
                    $originalDayHistory = $database->getDayHistory($date);
                }

                $dayHistory->setDate($date);
            } else {
                $this->_f3->set("errors[date]", "*Date is required and needs to follow the correct format");
            }

            if ($validator->validPosition($employeePosition)) {
                $incident->setPosition($employeePosition);

                if (empty($originalDayHistory['totalIncidents'])) {
                    $dayHistory->setTotalIncidents(1);
                } else {
                    $dayHistory->setTotalIncidents($originalDayHistory['totalIncidents'] + 1);
                }

                //shd1
                if ($employeePosition == 1) {
                    if (empty($originalDayHistory['totalSHD1Incidents'])) {
                        $dayHistory->setShd1Incidents(1);
                    } else {
                        $dayHistory->setShd1Incidents($originalDayHistory['totalSHD1Incidents'] + 1);
                    }

                    if (empty($originalDayHistory['totalSHD2Incidents'])) {
                        $dayHistory->setShd2Incidents(0);
                    } else {
                        $dayHistory->setShd2Incidents($originalDayHistory['totalSHD2Incidents']);
                    }
                } //shd2
                else if ($employeePosition == 2) {
                    if (empty($originalDayHistory['totalSHD2Incidents'])) {
                        $dayHistory->setShd2Incidents(1);
                    } else {
                        $dayHistory->setShd2Incidents($originalDayHistory['totalSHD2Incidents'] + 1);
                    }

                    if (empty($originalDayHistory['totalSHD1Incidents'])) {
                        $dayHistory->setShd1Incidents(0);
                    } else {
                        $dayHistory->setShd1Incidents($originalDayHistory['totalSHD1Incidents']);
                    }
                }
            } else {
                $this->_f3->set("errors[employeePosition]", "*Position is required");
            }

            if ($validator->validContactMethod($clientMethod)) {
                $incident->setContactMethod($clientMethod);

                if ($clientMethod == "zoom") {
                    if (empty($originalDayHistory['totalZoomIncidents'])) {
                        $dayHistory->setZoomIncidents(1);
                    } else {
                        $dayHistory->setZoomIncidents($originalDayHistory['totalZoomIncidents'] + 1);
                    }

                    if (empty($originalDayHistory['totalPhoneIncidents'])) {
                        $dayHistory->setPhoneIncidents(0);
                    } else {
                        $dayHistory->setPhoneIncidents($originalDayHistory['totalZoomIncidents']);
                    }
                } else if ($clientMethod == "phone") {
                    if (empty($originalDayHistory['totalPhoneIncidents'])) {
                        $dayHistory->setPhoneIncidents(1);
                    } else {
                        $dayHistory->setPhoneIncidents($originalDayHistory['totalPhoneIncidents'] + 1);
                    }

                    if (empty($originalDayHistory['totalZoomIncidents'])) {
                        $dayHistory->setZoomIncidents(0);
                    } else {
                        $dayHistory->setZoomIncidents($originalDayHistory['totalZoomIncidents']);
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

                if (empty($originalDayHistory['totalIncidentsReportsFiled'])) {
                    $dayHistory->setIncidentReportsFiled(1);
                } else {
                    $dayHistory->setIncidentReportsFiled(
                        $originalDayHistory['totalIncidentsReportsFiled'] + 1);
                }

                if ($validator->validIncidentReport($clientIncReportNum)) {
                    $clientIncReportNum = (int)($clientIncReportNum);
                    $incident->setIncidentReportNum($clientIncReportNum);
                } else {
                    $this->_f3->set("errors[clientIncReportNum]", "*Incident report number can only contain numbers");
                }
            } else {
                $incident->setFiledIncidentReport("No");

                if (empty($originalDayHistory['totalIncidentsReportsFiled'])) {
                    $dayHistory->setIncidentReportsFiled(0);
                } else {
                    $dayHistory->setIncidentReportsFiled($originalDayHistory['totalIncidentsReportsFiled']);
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

                $database->updateDayHistory($dayHistory);

                $_SESSION['dayHistory'] = $dayHistory;

                //Email submission
                $incidentID = $database->getIncidentID($_SESSION['incident']);
                $name = $_SESSION['employee']->getFirstName() . " " . $_SESSION['employee']->getLastName();
                $timeHelped = $_SESSION['incident']->getTimeHelped();
                $dateHelped = $_SESSION['incident']->getDateHelped();
                $position = $_SESSION['incident']->getPosition();
                $contactMethod = $_SESSION['incident']->getContactMethod();
                $location = $_SESSION['incident']->getLocation();

                if (!empty($_SESSION['incident']->getLocationOther())) {
                    $location = $_SESSION['incident']->getLocationOther();
                }

                $question = $_SESSION['incident']->getQuestion();

                if (!empty($_SESSION['incident']->getQuestionOther())) {
                    $question = $_SESSION['incident']->getQuestionOther();
                }

                if (!empty($_SESSION['incident']->getIncidentReportNum())) {
                    $incidentReportNum = $_SESSION['incident']->getIncidentReportNum();
                }

                if (!empty($_SESSION['incident']->getComments())) {
                    $comments = $_SESSION['incident']->getComments();
                }

                $submissionTime = $_SESSION['incident']->getSubmissionTime();

                $fromName = "Green River College Patron Tracker";
                $fromEmail = "Dhoward18@mail.greenriver.edu";

                $toEmail = "Dhoward@greenriver.edu";
                $subject = "Patron Form #$incidentID";
                $headers = "Name: $fromName <$fromEmail>";

                $message = "\nPatron Form Submission #$incidentID Overview\n\n";
                $message .= "Employee Name: $name\n";
                $message .= "Date Helped: $dateHelped\n";
                $message .= "Time Helped: $timeHelped\n";
                $message .= "Position: $position\n";
                $message .= "Contact Method: $contactMethod\n";
                $message .= "Location: $location\n";
                $message .= "Question: $question\n";

                if (!empty($incidentReportNum)) {
                    $message .= "Incident Report: $incidentReportNum\n";
                } else {
                    $message .= "Incident Report: N/A\n";
                }

                if (!empty($comments)) {
                    $message .= "Comments: $comments\n";
                }

                $message .= "Form Submitted: $submissionTime\n";

                $sendEmail = mail($toEmail, $subject, $message, $headers);

                //Redirect to submission page
                $this->_f3->reroute('/submission');
            }
        }

        //get arrays
        $this->_f3->set('questions', $dataLayer->getQuestions());
        $this->_f3->set('locations', $dataLayer->getLocations());
        $this->_f3->set('positions', $dataLayer->getPositions());
        $this->_f3->set('methods', $dataLayer->getContactMethods());

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

