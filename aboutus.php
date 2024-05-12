<?php
	include 'connect.php';
?>

<html>
	<head>
		<title> TaskEase - About Us</title>
		<link rel="stylesheet" href="css/aboutus.css">
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
				<span> ABOUT US </span>
			</div>
		</div>
					
		<div class = "aboutus-body">
			<div class = "aboutus-content">
				<div class="content-header">
					<text> ABOUT US </text>
					<hr/>
				</div>
									
				<div class="content-text">
					<span>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
						Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure 
						dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</span>
				</div>
			</div>
				
			<div class = "aboutus-img-content">
				<img src = "images/taskeaseLogo2.png"/>
			</div>
		</div>
	</body>
</html>









