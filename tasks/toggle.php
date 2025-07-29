<?php
session_start();
include '../config/db.php';
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) die('Invalid CSRF');
$id = $_POST['id'];
$conn->query("UPDATE tasks SET is_done = NOT is_done WHERE id=$id");
header("Location: ../dashboard.php");
?>