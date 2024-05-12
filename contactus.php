<?php
	include 'connect.php';
?>

<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<title> TaskEase - Contact Us </title>
		<link rel="stylesheet" href="css/contactusCSS.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syncopate:wght@700&display=swap">
		<script src="js/redirect-pages.js"></script>
		<script src="js/format-pages.js"></script>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0">
	</head>
   
	<body>
		<div class="page-header">
			<div class="header-home" onclick="redirectToIndex();">
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
			</div>
			
			<div class="header-identifier" onmouseover="changeContent()" onmouseout="resetContent()" onclick="redirectToLast();">
				<span> CONTACT US </span>
			</div>
		</div>
		
		<div>
			<br/>
		</br>
		
		<div class="container">
			<div class="content">
				<div class="left-side">
					<div class="address details">
						<i class="fas fa-map-marker-alt"></i>
						<div class="topic">Address</div>
						<div class="text-one"> N. Bacalso Avenue</div>
						<div class="text-two">Cebu City, Philippines</div>
					</div>
					
					<div class="phone details">
						<i class="fas fa-phone-alt"></i>
						<div class="topic">Phone</div>
						<div class="text-one">+63 32 2617743</div>
						<div class="text-two">+63 32 411 2000</div>
					</div>
					
					<div class="email details">
						<i class="fas fa-envelope"></i>
						<div class="topic">Email</div>
						<div class="text-one">taskease@gmail.com</div>
						<div class="text-two">info@taskease.edu</div>
					</div>
				</div>
		  
				<div class="right-side">
					<div class="topic-text">Send us a message</div>
					<p>If you have any work from me or any types of quries related to my tutorial, you can send me message from here. It's my pleasure to help you.</p>
				  
					<form action="#">
						<div class="input-box">
							<input type="text" placeholder="Enter your name">
						</div>
						
						<div class="input-box">
							<input type="text" placeholder="Enter your email">
						</div>
						
						<div class="input-box message-box">
							<input type = "text" placeholder = "Enter your message">
						</div>
						
						<div class="button">
							<input type="button" value="Send Now" >
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>

</html>