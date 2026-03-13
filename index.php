<?php
ob_start();
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TaskEase — Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/hand-drawn.css">
  <script src="js/redirect-pages.js"></script>
  <script src="js/format-pages.js"></script>
</head>
<body>

  <nav class="navbar">
    <div class="navbar-brand" onclick="redirectToIndex()">
      <img src="images/taskeaseLogo2.png" alt="TaskEase">
      <span class="navbar-brand-name">TaskEase</span>
    </div>
    <div class="navbar-links">
      <span class="nav-link primary" onclick="redirectToIndex()">Home</span>
      <span class="nav-link" onclick="redirectToAboutus()">About Us</span>
      <span class="nav-link" onclick="redirectToContactus()">Contact Us</span>
      <span class="nav-link" onclick="redirectToLogin()">Log In</span>
      <span class="nav-link primary" onclick="redirectToRegister()">Sign Up →</span>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero">
    <div class="hero-text">
      <div class="hero-tag">📋 Your personal task manager</div>
      <h1 class="hero-title">
        Get things<br>
        <span class="accent">done!</span>
      </h1>
      <p class="hero-subtitle">
        Simplify your tasks effortlessly. Stay organized,<br>
        stay productive — the human way.
      </p>
      <div class="hero-cta">
        <span class="btn btn-primary" onclick="redirectToRegister()">Get Started →</span>
        <span class="btn" onclick="redirectToLogin()">Log In</span>
      </div>
    </div>
    <div class="hero-image">
      <img src="images/taskease-img1.jpg" alt="TaskEase preview">
    </div>
  </section>

  <!-- Features -->
  <div class="features">
    <div class="feature-card">
      <div class="feature-icon">✅</div>
      <div class="feature-title">Track Tasks</div>
      <div class="feature-desc">Create, update, and complete tasks with ease.</div>
    </div>
    <div class="feature-card">
      <div class="feature-icon">⭐</div>
      <div class="feature-title">Mark Important</div>
      <div class="feature-desc">Star the tasks that need your attention first.</div>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🗑️</div>
      <div class="feature-title">Trash & Restore</div>
      <div class="feature-desc">Deleted tasks go to the bin — restore anytime.</div>
    </div>
    <div class="feature-card">
      <div class="feature-icon">📊</div>
      <div class="feature-title">Reports</div>
      <div class="feature-desc">See your task stats and stay on top of things.</div>
    </div>
  </div>

</body>
</html>
