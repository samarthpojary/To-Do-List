<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) die('Invalid CSRF');
$user_id = $_SESSION['user_id'];
$id = $_POST['id'];

$stmt = $conn->prepare("UPDATE tasks SET is_done = NOT is_done WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$stmt->close();

header("Location: ../dashboard.php");
?>
