<?php
ob_start();
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TaskEase — Contact Us</title>
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
      <span class="nav-link primary" onclick="redirectToContactus()">Contact Us</span>
      <span class="nav-link" onclick="redirectToLogin()">Log In</span>
      <span class="nav-link primary" onclick="redirectToRegister()">Sign Up →</span>
    </div>
  </nav>

  <div class="page-hero">
    <div class="page-hero-tag">📬 Reach Out</div>
    <h1 class="page-hero-title">Contact Us</h1>
    <p class="page-hero-sub">Have a question or just want to say hi? We'd love to hear from you.</p>
  </div>

  <div class="contact-wrap">

    <!-- Info -->
    <div class="content-card" style="transform:rotate(-0.5deg);">
      <h2 style="font-family:var(--font-h); font-size:1.3rem; margin-bottom:1.25rem; border-bottom:2px dashed var(--muted); padding-bottom:0.5rem;">
        Get in Touch
      </h2>

      <div class="contact-info-item">
        <div class="contact-icon">📍</div>
        <div>
          <div class="contact-topic">Address</div>
          <div class="contact-text">N. Bacalso Avenue<br>Cebu City, Philippines</div>
        </div>
      </div>

      <div class="contact-info-item">
        <div class="contact-icon">📞</div>
        <div>
          <div class="contact-topic">Phone</div>
          <div class="contact-text">+63 32 2617743<br>+63 32 411 2000</div>
        </div>
      </div>

      <div class="contact-info-item">
        <div class="contact-icon">✉️</div>
        <div>
          <div class="contact-topic">Email</div>
          <div class="contact-text">taskease@gmail.com<br>info@taskease.edu</div>
        </div>
      </div>
    </div>

    <!-- Message form -->
    <div class="content-card" style="transform:rotate(0.4deg);">
      <h2 style="font-family:var(--font-h); font-size:1.3rem; margin-bottom:0.4rem;">
        Send a Message
      </h2>
      <p style="font-size:0.88rem; color:rgba(45,45,45,0.6); margin-bottom:1.25rem;">
        Fill in the form and we'll get back to you as soon as possible.
      </p>

      <form action="#">
        <div class="field-wrap">
          <label>Your Name</label>
          <input class="input-field" type="text" placeholder="Juan Dela Cruz">
        </div>

        <div class="field-wrap">
          <label>Your Email</label>
          <input class="input-field" type="text" placeholder="you@email.com">
        </div>

        <div class="field-wrap">
          <label>Message</label>
          <textarea class="input-field" placeholder="Type your message here..."
            rows="4" style="resize:vertical;"></textarea>
        </div>

        <button class="btn btn-primary" type="button" style="width:100%;">
          Send Now →
        </button>
      </form>
    </div>

  </div>

</body>
</html>
