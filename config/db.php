<?php
$host = 'localhost';
$db   = 'jwt_auth';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$conn = mysqli_connect($host, $user, $pass, $db) or die('Error connecting to MySQL server.');

mysqli_set_charset($conn, $charset);

?>
