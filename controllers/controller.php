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
        //Display a view
        $view = new Template();
        echo $view->render('views/form.html');
    }

}
