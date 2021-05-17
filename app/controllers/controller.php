<?php

namespace Controllers;

use Session;

//! Base controller
class Controller {

	//! HTTP route pre-processor
	function beforeroute($f3) {
	}

	//! Instantiate class
	function __construct() {
		// Connect to the database
		new Session();
	}

}
