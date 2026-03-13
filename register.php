<?php
ob_start();
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TaskEase — Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/hand-drawn.css">
  <script src="js/redirect-pages.js"></script>
</head>
<body>

  <nav class="navbar">
    <div class="navbar-brand" onclick="redirectToIndex()">
      <img src="images/taskeaseLogo2.png" alt="TaskEase">
      <span class="navbar-brand-name">TaskEase</span>
    </div>
    <div class="navbar-links">
      <span class="nav-link" onclick="redirectToIndex()">Home</span>
      <span class="nav-link" onclick="redirectToAboutus()">About Us</span>
      <span class="nav-link" onclick="redirectToLogin()">Log In</span>
    </div>
  </nav>

  <div class="auth-page">
    <div class="auth-card" style="max-width:500px;">
      <div class="auth-tape"></div>

      <h1 class="auth-title">Join TaskEase ✏️</h1>
      <p class="auth-subtitle">Create your free account</p>

      <?php
      if (isset($_POST['btnRegister'])) {
        $firstname        = $_POST['firstname'];
        $lastname         = $_POST['lastname'];
        $username         = $_POST['username'];
        $email            = $_POST['emailadd'];
        $password         = $_POST['password'];
        $confirmedpassword = $_POST['confirmpassword'];

        if ($password != $confirmedpassword) {
          echo '<div class="auth-error">⚠️ Passwords do not match.</div>';
        } else {
          $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbluseraccount WHERE username = :username");
          $stmt->execute([':username' => $username]);
          $user_row = $stmt->fetchColumn();

          $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbluseraccount WHERE emailadd = :emailadd");
          $stmt->execute([':emailadd' => $email]);
          $email_row = $stmt->fetchColumn();

          if ($user_row == 0 && $email_row == 0) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare(
              "INSERT INTO tbluseraccount (username, emailadd, password)
               VALUES (:username, :emailadd, :password)
               RETURNING acctid"
            );
            $stmt->execute([
              ':username' => $username,
              ':emailadd' => $email,
              ':password' => $hashed_password,
            ]);
            $acctid = $stmt->fetchColumn();

            $stmt = $pdo->prepare(
              "INSERT INTO tbluserprofile (firstname, lastname, acctid)
               VALUES (:firstname, :lastname, :acctid)"
            );
            $stmt->execute([
              ':firstname' => $firstname,
              ':lastname'  => $lastname,
              ':acctid'    => $acctid,
            ]);

            $_SESSION['success'] = "Registration successful.";
            header('location: login.php');
            exit;
          } else {
            if ($user_row != 0) {
              echo '<div class="auth-error">⚠️ Username already exists.</div>';
            } else {
              echo '<div class="auth-error">⚠️ Email already exists.</div>';
            }
          }
        }
      }
      ?>

      <form method="post" action="#">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0 1rem;">
          <div class="field-wrap">
            <label>First Name</label>
            <input class="input-field" type="text" name="firstname" placeholder="Juan" required>
          </div>
          <div class="field-wrap">
            <label>Last Name</label>
            <input class="input-field" type="text" name="lastname" placeholder="Dela Cruz" required>
          </div>
        </div>

        <div class="field-wrap">
          <label>Username</label>
          <input class="input-field" type="text" name="username" placeholder="choose a username" required>
        </div>

        <div class="field-wrap">
          <label>Email</label>
          <input class="input-field" type="text" name="emailadd" placeholder="you@email.com" required>
        </div>

        <div class="field-wrap">
          <label>Password</label>
          <input class="input-field" type="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="field-wrap">
          <label>Confirm Password</label>
          <input class="input-field" type="password" name="confirmpassword" placeholder="••••••••" required>
        </div>

        <button class="btn btn-primary" type="submit" name="btnRegister"
          style="width:100%; margin-top:0.5rem;">
          Create Account →
        </button>
      </form>

      <p class="auth-footer">
        Already have an account? <a href="login.php">Log in</a>
      </p>
    </div>
  </div>

</body>
</html>
