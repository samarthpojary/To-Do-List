<?php
$host = 'localhost';
$user = 'root';
$pass = 'Samarth@9019';
$db = 'todo_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>