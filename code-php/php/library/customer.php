<?php
/*
* customer library class
* @TODO, re-code to class
*/
// dependencies
require_once 'config.php';

function infoMatch($email, $country, $db) {
    try {
        // retrieve information
        $select = $db->query('SELECT * FROM customer WHERE email = ? AND country = ?', 
            array($email, $country))->fetchArray();
    } catch(Exception $error) {
        $data['errorStatus'] = true;
        $data["errorMessage"] = $error;
    } finally {
        $db->close();
    }

    if (!empty($select['idcustomer'])) {
        return true;
    } else {
        return false;
    }
}

function fetchCustomer($email, $db) {
    try {
        // retrieve information
        $select = $db->query('SELECT * FROM customer WHERE email = ?', 
            array($email))->fetchArray();            
    } catch(Exception $error) {
        $data['errorStatus'] = true;
        $data["errorMessage"] = $error;
    } finally {
        $db->close();
    }

   
}