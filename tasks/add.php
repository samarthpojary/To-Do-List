<?php
session_start();
include '../config/db.php';
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) die('Invalid CSRF');

$task = trim($_POST['task']);
$due_date = $_POST['due_date'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO tasks (user_id, task, due_date) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $task, $due_date);
$stmt->execute();

header("Location: ../dashboard.php");
?>