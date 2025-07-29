<?php
session_start();
include '../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = 'Error: Username may already exist.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="container" style="margin-top: 80px;">
    <h1>Register</h1>
    <?php if ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="username" required placeholder="Username" autocomplete="username">
      <input type="password" name="password" required placeholder="Password" autocomplete="new-password">
      <button type="submit">Register</button>
    </form>
    <div style="margin-top: 12px; color: var(--muted); font-size: 0.97em;">
      Already have an account? <a href="login.php" class="btn" style="background: none; color: var(--primary); padding: 0;">Login</a>
    </div>
  </div>
</body>
</html>