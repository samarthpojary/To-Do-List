<?php
session_start();
include '../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed);
        $stmt->fetch();
        if (password_verify($password, $hashed)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: ../dashboard.php");
            exit();
        }
    }
    $error = 'Invalid login.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="container" style="margin-top: 80px;">
    <h1><i class="fas fa-sign-in-alt"></i> Login</h1>
    <?php if ($error): ?>
      <div class="error"><i class="fas fa-exclamation-triangle"></i> <?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="username" required placeholder="Username" autocomplete="username">
      <input type="password" name="password" required placeholder="Password" autocomplete="current-password">
      <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
    </form>
    <div style="margin-top: 12px; color: var(--muted); font-size: 0.97em;">
      Don't have an account? <a href="register.php" class="btn" style="background: none; color: var(--primary); padding: 0;"><i class="fas fa-user-plus"></i> Register</a>
    </div>
  </div>
</body>
</html>
