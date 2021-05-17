<?php

function varDie($args) {
    echo '<pre>';
    var_dump($args);
    die();
}
function render($view, $args = [], $type = "text/html") {
    return (\View::instance())
        ->render($view, $type, $args);
}
// Retrieve instance of the framework
require(__DIR__.'/../vendor/autoload.php');
$f3 = Base::instance();
$f3->set('_DEBUG.time', hrtime(true));

// Initialize CMS
$f3->config(__DIR__.'/../app/config.ini');
Benchmark::instance();

// Define routes
$f3->config(__DIR__.'/../app/routes.ini');

// Execute application
$f3->run();
