<?php
/*
* Security API
* @Author: Edison Quinones Jr.
* 
*/
header('Content-type: application/json');

// error displays
// error_reporting(E_ALL);
ini_set('display_errors', 1); 

// dependencies
require_once './library/config.php';
include_once './library/customer.php';

// request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

// session
session_start();

// initial declration
$data = [
    "errorStatus" => false,
    "errorMessage" => ''
];


// required fields
if ($requestMethod === 'POST') {
    $email = strtolower(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
    $country = strtolower(filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING));
    if ($email && $country && infoMatch($email, $country, $db)) {
        $_SESSION['email'] = sha1($email);
        echo json_encode($data);
        exit();
    } else {
        // 405 Method Not Allowed
        header("HTTP/1.1 405 Method Not Allowed");

        $data['errorStatus'] = true;
        $data["errorMessage"] = 'Invalid inputs';
        echo json_encode($data);
        exit();
    }
}


#### collecton of function for security
 