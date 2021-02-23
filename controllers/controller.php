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

        //get arrays
        $this->_f3->set('questions', $dataLayer->getQuestions());
        $this->_f3->set('locations', $dataLayer->getLocations());
        $this->_f3->set('positions', $dataLayer->getPositions());
        $this->_f3->set('methods', $dataLayer->getContactMethods());
        $this->_f3->set('incidentReports', $dataLayer->getIncidentReportOptions());



        //Display a view
        $view = new Template();
        echo $view->render('views/form.html');
    }

}
