<?php 
include 'db.php';
session_start();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'quiz';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

?>