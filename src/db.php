<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Specify database credentials here
$username = 'root';
$password = 'root';
$host = 'localhost';
$dbname = 'houses';
$pdo = null;

// Connect to the database
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
  die("Could not connect to the database $dbname: " . $e->getMessage());
}
?>