<?php

//this code is used to call the booking controller and display -
//the errors found within the errors array in the booking controller

require_once 'bookingController.php';

$controller = new bookingController();

if ($controller->validate_input()) {
    echo "<h2>Validation passed!</h2>";
    echo "<pre>";
    print_r($controller->getData());
    echo "</pre>";
} else {
    echo "<h2>Validation failed:</h2>";
    echo "<ul>";
    foreach ($controller->getErrors() as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</ul>";
}