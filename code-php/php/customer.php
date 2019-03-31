<?php
/*
* Customer CUSTOMER API
* @Author: Edison Quinones Jr.
* 
*/
header('Content-type: application/json');

// error displays
// error_reporting(E_ALL);
ini_set('display_errors', 0);

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
    $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
    $email= filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $city= filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);
    $uploadedImage = filter_input(INPUT_POST, "uploaded-image", FILTER_SANITIZE_STRING);

    $data = [
        "errorStatus" => false,
        "email" => $email,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "city" => $city,
        "country" => $country,
        "uploadedImage" => $uploadedImage
    ];
} elseif ($requestMethod === 'GET') {
    $email= filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL);
    $data['email'] = $email;
} elseif ($requestMethod === 'PUT') {
    $email= filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL);
    $firstname= filter_input(INPUT_GET, "firstname", FILTER_SANITIZE_STRING);
    $lastname= filter_input(INPUT_GET, "lastname", FILTER_SANITIZE_STRING);
    $city= filter_input(INPUT_GET, "city", FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_GET, "country", FILTER_SANITIZE_STRING);
    $uploadedImage = filter_input(INPUT_GET, "uploaded-image", FILTER_SANITIZE_STRING);

    $data = [
        "errorStatus" => false,
        "email" => $email,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "city" => $city,
        "country" => $country,
        "uploadedImage" => $uploadedImage
    ];
} elseif ($requestMethod === 'DELETE') {
    $email= filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL);
    $data['email'] = $email;
} else {
    // 405 Method Not Allowed
    header("HTTP/1.1 405 Method Not Allowed");
    header('Content-type: application/json');

    $data['errorStatus'] = true;
    $data["errorMessage"] = 'not allowed method';
    echo json_encode($data);
    exit();
}


## call of functions base on request method
if ($requestMethod === 'POST')
    $data = create($data, $db);
elseif ($requestMethod === 'GET') {
    // security check
    securityCheck($_SESSION['email'],$data['email']);
    $data = read($data, $db);
} elseif ($requestMethod === 'PUT') {
    securityCheck($_SESSION['email'],$data['email']);
    $data = update($data, $db);
} else {
    // 405 Method Not Allowed
    header("HTTP/1.1 405 Method Not Allowed");
    header('Content-type: application/json');

    $data['errorStatus'] = true;
    $data["errorMessage"] = 'Invalid or missing required inputs';
    echo json_encode($data);
    exit();
}

// save the email, SECURITY reasons
if ($requestMethod === 'POST' )
    $_SESSION['email'] = sha1($email);

// display
echo json_encode($data);


#### collection of functions
function create($data, $db) {
    if (!$data['email']) {
        $data['errorStatus'] = true;
        $data["errorMessage"] = 'Email invalid or empty';
        header("HTTP/1.1 400 Bad Request");
    } elseif (!$data['firstname'] || !$data['lastname'] || !$data['city'] || !$data['country'] || !$data['uploadedImage']) {
        $data['errorStatus'] = true;
        $data["errorMessage"] = 'Invalid or missing required inputs';
        header("HTTP/1.1 400 Bad Request");
    } else {
        try {
            $insert = $db->query('INSERT INTO customer (firstname,lastname,email,city, country) 
            VALUES (?,?,?,?,?)', 
                $data['firstname'], 
                $data['lastname'], 
                $data['email'], 
                $data['city'], 
                $data['country']);
                
            if ($insert->affectedRows() > 0) {
                $select = $db->query('SELECT idcustomer FROM customer WHERE email = ?', 
                    array($data['email']))->fetchArray();
                $insert = $db->query('INSERT INTO profilepictures (active,customer_idcustomer, filename) 
                VALUES (?,?,?)', 
                    1, 
                    $select['idcustomer'], 
                    $data['uploadedImage']);
            }
            
        } catch(Exception $error) {
            $data['errorStatus'] = true;
            $data["errorMessage"] = $error;
        } finally {
            $db->close();
        }        
    }
    
    return $data;
}

function read($data, $db) {
    if (!$data['email']) {
        $data['errorStatus'] = true;
        $data["errorMessage"] = 'Invalid or missing required inputs';
        header("HTTP/1.1 400 Bad Request");
    } else {
        
        try {
            // retrieve information
            $select = $db->query('SELECT * FROM customer WHERE email = ?', 
                array($data['email']))->fetchArray();
            $data = $select;

            // retrieve pictures
            $select = $db->query('SELECT * FROM profilepictures WHERE customer_idcustomer = ?', 
                array($select['idcustomer']))->fetchArray();
            $data['filename'] = $select['filename'];

            
        } catch(Exception $error) {
            $data['errorStatus'] = true;
            $data["errorMessage"] = $error;
        } finally {
            $db->close();
        }
    }
    return $data;
}

function update($data, $db) {
    // no entry here, not needed for the requirement yet
    return $data;
}

function delete($data, $db) {
    // no entry here, not needed for the requirement yet
    return $data;
}

function securityCheck($session, $email) {
    if (sha1($email) != $session) {
        header("HTTP/1.1 400 Bad Request");
        header('Content-type: application/json');
        $data['errorStatus'] = true;
        $data["errorMessage"] = 'not allowed to retrieve customer';
        echo json_encode($data);
        exit();   
    }
    return false;
}


?>
