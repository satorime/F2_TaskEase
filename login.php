<?php
ob_start();
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TaskEase — Log In</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/hand-drawn.css">
  <script src="js/redirect-pages.js"></script>
</head>
<body>

  <nav class="navbar">
    <div class="navbar-brand" onclick="redirectToIndex()">
      <img src="images/logo.svg" alt="TaskEase">
      <span class="navbar-brand-name">TaskEase</span>
    </div>
    <div class="navbar-links">
      <span class="nav-link" onclick="redirectToIndex()">Home</span>
      <span class="nav-link" onclick="redirectToAboutus()">About Us</span>
      <span class="nav-link" onclick="redirectToRegister()">Sign Up</span>
    </div>
  </nav>

  <div class="auth-page">
    <div class="auth-card">
      <div class="auth-tape"></div>

      <h1 class="auth-title">Welcome back ✏️</h1>
      <p class="auth-subtitle">stylish tasks, the new norm</p>

      <?php
      if (isset($_POST['btnLogin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM tbluseraccount WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();

        if (!$row) {
          echo '<div class="auth-error">⚠️ Username not found.</div>';
        } elseif (!password_verify($password, $row['password'])) {
          echo '<div class="auth-error">⚠️ Incorrect password.</div>';
        } else {
          $_SESSION['username'] = $row['username'];
          header("location: dashboard.php");
          exit;
        }
      }
      ?>

      <form method="post" action="#">
        <div class="field-wrap">
          <label>Username</label>
          <input class="input-field" type="text" name="username" placeholder="your username" required>
        </div>

        <div class="field-wrap">
          <label>Password</label>
          <div class="pw-wrap">
            <input class="input-field" type="password" id="pw-login" name="password" placeholder="••••••••" required>
            <button type="button" class="pw-toggle" onclick="togglePw('pw-login', this)" title="Show/hide">👁</button>
          </div>
        </div>

        <button class="btn btn-primary" type="submit" name="btnLogin"
          style="width:100%; margin-top:0.5rem;">
          Log In →
        </button>
      </form>

      <p class="auth-footer">
        Not a member? <a href="register.php">Sign up now</a>
      </p>
    </div>
  </div>

<script>
function togglePw(id, btn) {
  var inp = document.getElementById(id);
  if (inp.type === 'password') {
    inp.type = 'text';
    btn.textContent = '🙈';
  } else {
    inp.type = 'password';
    btn.textContent = '👁';
  }
}
</script>
</body>
</html>
