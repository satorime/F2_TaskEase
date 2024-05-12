<?php
	include 'connect.php';
?>

<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title> Task Ease - Log In</title>
		<link rel="stylesheet" href="css/loginCSS.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syncopate:wght@700&display=swap">
		<script src="js/redirect-pages.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			
			<div class="header-identifier">
				<span> LOG IN</span>
			</div>
		</div>
		
		<div class="login-body">
			<div class="login-body-content">
				<div class="content-header">
					<span class="header-welcome"> Welcome</span> <br/>
					<span class="header-text"> stylish tasks, the new norm</span>
				</div>
				 
				<form action="#" method="post">
					<div class="field">
						<input type="text" name = "username" required>
						<label>Username</label>
					</div>	
					
					<div class="field">
						<input type="password" name = "password" required>
						<label>Password</label>
					</div>
					
					<div class="field">
						<input type="submit" name = "btnLogin" value="Login">
					</div>
					
					<div class="signup-link">
						Not a member? <a href="register.php"> Signup now</a>
					</div>
				 </form>
			 </div>
			 
			 <div class="login-body-img">
				<img src="images/taskease-img2.jpg">
			 </div>
		</div>
		
		<?php	
	if(isset($_POST['btnLogin'])){
		$username = mysqli_real_escape_string($connection, $_POST['username']);
		$password = $_POST['password'];
		
		// Check tbluseraccount if username is existing
		$sql = "SELECT * FROM tbluseraccount WHERE username='".$username."'";
		$result = mysqli_query($connection, $sql);   
		
		$count = mysqli_num_rows($result);
		$row = mysqli_fetch_assoc($result);
		
		if($count == 0){
			echo $error_username_exists = "Username not exists.";
		} else {
			// Verify password
			if(password_verify($password, $row['password'])){
				$_SESSION['username'] = $row['username'];
				header("location: dashboard.php");
				exit; 
			} else {
				echo $error_incorrect_pass = "Incorrect password";
			}
		}
	}
?>
	</body>
	
</html>