<?php
session_start();
include 'config/db.php';
if (!isset($_SESSION['user_id'])) header("Location: auth/login.php");

$user_id = $_SESSION['user_id'];
$csrf_token = $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id=? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasks = $stmt->get_result();

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
      <h1>My To-Do List</h1>
      <button id="dark-mode-toggle" class="btn" style="background: var(--muted); color: var(--text); padding: 8px 12px;"><i class="fas fa-moon"></i></button>
    </div>
    <form action="tasks/add.php" method="POST">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input name="task" required placeholder="New task">
      <input type="date" name="due_date">
      <button type="submit">Add</button>
    </form>
    <ul class="todo-list">
      <?php while($row = $tasks->fetch_assoc()): ?>
        <li class="todo-item<?= $row['is_done'] ? ' completed' : '' ?>">
          <form action="tasks/toggle.php" method="POST" style="display: flex; align-items: center; flex: 1;">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="checkbox" class="checkbox" name="is_done" onchange="this.form.submit()"<?= $row['is_done'] ? ' checked' : '' ?>>
            <span style="flex:1;">
              <?= htmlspecialchars($row['task']) ?>
              <span style="color: var(--muted); font-size: 0.95em;">(Due: <?= $row['due_date'] ?>)</span>
            </span>
          </form>
          <form action="tasks/delete.php" method="POST" style="margin-left: 8px;">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <button class="delete-btn" title="Delete">&#128465;</button>
          </form>
        </li>
      <?php endwhile; ?>
    </ul>
    <div style="margin-top: 18px;">
      <a href="export_excel.php" class="btn" style="background: var(--success); color: #fff; margin-right: 10px;"><i class="fas fa-file-excel"></i> Export to Excel</a>
      <a href="logout.php" class="btn" style="background: var(--danger); color: #fff;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
  <script>
    const toggleButton = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const icon = toggleButton.querySelector('i');

    toggleButton.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
      if (body.classList.contains('dark-mode')) {
        icon.className = 'fas fa-sun';
      } else {
        icon.className = 'fas fa-moon';
      }
    });
  </script>
</body>
</html>
