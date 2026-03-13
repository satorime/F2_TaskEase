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
      <img src="images/logo.svg" alt="TaskEase">
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
      <!-- Hand-drawn notepad illustration -->
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 380 320" style="width:100%;max-width:420px;transform:rotate(1.5deg);filter:drop-shadow(6px 6px 0 #2d2d2d);">
        <!-- Notepad shadow -->
        <rect x="28" y="28" width="324" height="268" rx="14" fill="#2d2d2d" opacity="0.12"/>
        <!-- Notepad body -->
        <rect x="22" y="22" width="324" height="268" rx="14"
              fill="#ffffff" stroke="#2d2d2d" stroke-width="3"/>
        <!-- Header bar -->
        <rect x="22" y="22" width="324" height="56" rx="14"
              fill="#fff9c4" stroke="#2d2d2d" stroke-width="3"/>
        <rect x="22" y="56" width="324" height="22" fill="#fff9c4"/>
        <!-- Title text -->
        <text x="50" y="60" font-family="Kalam,cursive" font-size="22" font-weight="700" fill="#2d2d2d">My Tasks ✏️</text>
        <!-- Spiral rings -->
        <circle cx="90"  cy="22" r="8" fill="#fdfbf7" stroke="#2d2d2d" stroke-width="2.5"/>
        <circle cx="150" cy="22" r="8" fill="#fdfbf7" stroke="#2d2d2d" stroke-width="2.5"/>
        <circle cx="210" cy="22" r="8" fill="#fdfbf7" stroke="#2d2d2d" stroke-width="2.5"/>
        <circle cx="270" cy="22" r="8" fill="#fdfbf7" stroke="#2d2d2d" stroke-width="2.5"/>
        <!-- Task 1 — checked -->
        <rect x="48" y="96" width="22" height="22" rx="5"
              fill="#2d5da1" stroke="#2d2d2d" stroke-width="2"/>
        <path d="M53 107 L59 114 L70 101" stroke="#ffffff" stroke-width="2.5" fill="none" stroke-linecap="round"/>
        <line x1="84" y1="107" x2="290" y2="107" stroke="#e5e0d8" stroke-width="14" stroke-linecap="round"/>
        <line x1="84" y1="107" x2="220" y2="107" stroke="#2d2d2d" stroke-width="1.5" stroke-linecap="round" opacity="0.35"/>
        <!-- Task 2 — checked -->
        <rect x="48" y="136" width="22" height="22" rx="5"
              fill="#2d5da1" stroke="#2d2d2d" stroke-width="2"/>
        <path d="M53 147 L59 154 L70 141" stroke="#ffffff" stroke-width="2.5" fill="none" stroke-linecap="round"/>
        <line x1="84" y1="147" x2="290" y2="147" stroke="#e5e0d8" stroke-width="14" stroke-linecap="round"/>
        <line x1="84" y1="147" x2="260" y2="147" stroke="#2d2d2d" stroke-width="1.5" stroke-linecap="round" opacity="0.35"/>
        <!-- Task 3 — active/red -->
        <rect x="48" y="176" width="22" height="22" rx="5"
              fill="#ff4d4d" stroke="#2d2d2d" stroke-width="2"/>
        <line x1="84" y1="187" x2="290" y2="187" stroke="#e5e0d8" stroke-width="14" stroke-linecap="round"/>
        <line x1="84" y1="187" x2="200" y2="187" stroke="#2d2d2d" stroke-width="1.5" stroke-linecap="round" opacity="0.35"/>
        <!-- Task 4 — empty -->
        <rect x="48" y="216" width="22" height="22" rx="5"
              fill="#fdfbf7" stroke="#2d2d2d" stroke-width="2"/>
        <line x1="84" y1="227" x2="290" y2="227" stroke="#e5e0d8" stroke-width="14" stroke-linecap="round"/>
        <line x1="84" y1="227" x2="240" y2="227" stroke="#2d2d2d" stroke-width="1.5" stroke-linecap="round" opacity="0.35"/>
        <!-- Star badge -->
        <circle cx="316" cy="100" r="18" fill="#fff9c4" stroke="#2d2d2d" stroke-width="2" opacity="0.9"/>
        <text x="307" y="106" font-size="18">⭐</text>
      </svg>
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
