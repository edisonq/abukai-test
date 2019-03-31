<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './library/config.php';

exit();

# below is just sample of how to use database.php
# query samples
// single
$account = $db->query('SELECT * FROM customer WHERE firstname = ? AND lastname = ?', array('test2', 'test2'))->fetchArray();
echo $account['firstname'];


// multiple
echo '<br><br>';
$accounts = $db->query('SELECT * FROM customer')->fetchAll();

foreach ($accounts as $account) {
	echo $account['firstname'] . '<br>';
}
// number of rows
echo '<br>';
$accounts = $db->query('SELECT * FROM customer');
echo $accounts->numRows();

// Checking the affected number of rows:
echo '<br>';
$insert = $db->query('INSERT INTO customer (firstname,lastname,email,city) 
VALUES (?,?,?,?)', 'test', 'test', 'test@gmail.com', 'Test');
echo $insert->affectedRows();

// query count
echo '<br>';
echo $db->query_count;

// close db
$db->close();



?>
