<?php
	include 'connect.php';
?>

<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title> Task Ease - Home</title>
		<link rel="stylesheet" href="css/index.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syncopate:wght@700&display=swap">
		<script src="js/redirect-pages.js"></script>
		<script src="js/format-pages.js"></script>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0">
	</head>
   
	<body>
		<div class="page-header">
			<div class="header-logo">
				<img src = "images/taskeaseLogo2.png" />
			</div>
					
			<div class="header-logo-name">
				<div class="name-upper-text">
					<span> TaskEase </span>
				</div>
					
				<div class="name-lower-text">
					<span> task managemen</span>t
				</div>
			</div>
				
			<div class="header-anchors" onclick="redirectToIndex();">
				<span> HOME </span>
			</div>
				
			<div class="header-anchors" onclick="redirectToAboutus();">
				<span> ABOUT US </span>
			</div>
					
			<div class="header-anchors" onclick="redirectToContactus();">
				<span> CONTACT US </span>
			</div>
										
			<div class="header-anchors" onclick="redirectToLogin();">
				<span> LOG IN </span>
			</div>
					
			<div class="header-anchors" onclick="redirectToRegister();">
				<span> SIGN IN </span>
			</div>
		</div>
		
		<div class="index-body">
			<div class="index-body-image">
				<img src = "images/taskease-img1.jpg"/>
			</div>
			
			<div class="index-body-text">
				<div class="text-welcome">
					<span> Welcome to TaskEase! </span>
				</div>
				
				<div class="text-welcome-content">
					<span> Simplify your task effortlessly. Get organized, stay <br/>productive. Let's make task tracking easy together! </span>
				</div>
			</div>
		</div>
		
	</body>
</html>