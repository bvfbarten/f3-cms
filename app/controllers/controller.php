<?php

namespace Controllers;

use Session;

//! Base controller
class Controller {

	//! HTTP route pre-processor
    function afterroute($f3) {
        if ($t = $f3->get('TEMPLATE')) {
            echo render($t);
        } else {
            if ($f3->get('PAGE')) {
                echo render($f3->get('PAGE'));
            }
        }
    }

	//! Instantiate class
	function __construct() {
		// Connect to the database
		new Session();
	}

}
