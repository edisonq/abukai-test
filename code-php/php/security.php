<?php
/*
* Customer CUSTOMER API
* @Author: Edison Quinones Jr.
* 
*/
header('Content-type: application/json');

// error displays
// error_reporting(E_ALL);
ini_set('display_errors', 1);

// dependencies
require_once './library/config.php';

// request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

// session
session_start();

// initial declration
$data = [
    "errorStatus" => false
];

// required fields
if ($requestMethod === 'POST') {
    $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
    $city= filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);

    if ($firstname || $city || $country) {
        
    }
}