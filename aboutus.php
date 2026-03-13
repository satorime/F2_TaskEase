<?php
ob_start();
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TaskEase — About Us</title>
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
      <span class="nav-link primary" onclick="redirectToAboutus()">About Us</span>
      <span class="nav-link" onclick="redirectToContactus()">Contact Us</span>
      <span class="nav-link" onclick="redirectToLogin()">Log In</span>
      <span class="nav-link primary" onclick="redirectToRegister()">Sign Up →</span>
    </div>
  </nav>

  <div class="page-hero">
    <div class="page-hero-tag">✏️ Our Story</div>
    <h1 class="page-hero-title">About Us</h1>
    <p class="page-hero-sub">We believe managing tasks should feel human, not mechanical.</p>
  </div>

  <div style="max-width:860px; margin:0 auto; padding:0 1.5rem 4rem; display:flex; flex-direction:column; gap:1.5rem;">

    <div class="content-card" style="transform:rotate(-0.5deg);">
      <h2 style="font-family:var(--font-h); font-size:1.4rem; margin-bottom:0.75rem;">
        📌 Who We Are
      </h2>
      <p>
        TaskEase is a task management platform built with one goal: make your day simpler.
        We started as a small project to help students and professionals stay on top of
        their responsibilities without the noise of bloated productivity tools.
      </p>
    </div>

    <div class="content-card" style="transform:rotate(0.4deg); background:var(--yellow);">
      <h2 style="font-family:var(--font-h); font-size:1.4rem; margin-bottom:0.75rem;">
        🎯 Our Mission
      </h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
        irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
        pariatur.
      </p>
    </div>

    <div class="content-card" style="transform:rotate(-0.3deg);">
      <h2 style="font-family:var(--font-h); font-size:1.4rem; margin-bottom:0.75rem;">
        🖊️ Our Logo
      </h2>
      <div style="display:flex; align-items:center; gap:2rem; flex-wrap:wrap;">
        <img src="images/taskeaseLogo2.png" alt="TaskEase Logo"
          style="width:100px; border:2px solid var(--fg); border-radius:var(--r-wobbly-sm); box-shadow:var(--shadow-sm); padding:0.5rem; background:var(--white);">
        <p style="flex:1; min-width:200px;">
          Our logo represents clarity and focus — the two things every productive day needs.
          Simple, bold, and unmistakably TaskEase.
        </p>
      </div>
    </div>

  </div>

</body>
</html>
