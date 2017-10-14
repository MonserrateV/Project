<?php
//ob_start();
session_start();

//db credentials
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'first_db');

try {
	//create PDO connection
	$db = new PDO("mysql:localhost=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
 catch (PDOException $e) {
	//show error
	echo $e->getMessage();
	exit;
}

//include the classes
include ('classes/user.php');

$user= new User($db);

//define page title
$title = "First PHP Project";
?>