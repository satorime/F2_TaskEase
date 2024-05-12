<?php
	include 'connect.php';
?>

<html lang="en" dir="ltr">
	<head>
		<meta charset = "UTF-8">
		<title> Task Ease - Register</title>
		<link rel="stylesheet" href="css/registerCSS.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syncopate:wght@700&display=swap">
		<script src="js/redirect-pages.js"></script>
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
			
			<div class="header-identifier">
				<span> REGISTER </span>
			</div>
		</div>
		
		<div class="register-body">
			<div class="body-header"> Registration </div>
			
			<div class="body-content">
				<form action="#" method="post">
					<div class="user-details">
						<div class="input-box">
							<span class="details"> First Name </span>
							<input type="text" name = "firstname" placeholder="Enter your first name" required>
						</div>
						
						<div class="input-box">
							<span class="details">Last Name </span>
							<input type="text" name = "lastname" placeholder="Enter your last name" required>
						</div>
						
						<div class="input-box">
							<span class="details"> Username </span>
							<input type="text" name = "username" placeholder="Enter your username" required>
						</div>
						
						<div class="input-box">
							<span class="details"> Email </span>
							<input type="text" name = "emailadd" placeholder="Enter your email" required>
						</div>
						
						<div class="input-box">
							<span class="details"> Password </span>
							<input type="text" name = "password" placeholder="Enter your password" required>
						</div>
						
						<div class="input-box">
							<span class="details"> Confirm Password </span>
							<input type="text" name = "confirmpassword" placeholder="Confirm your password" required>
						</div>
					</div>
					
					<div class="register-button">
						<input type="submit" name="btnRegister" value="Register">
					</div>
				</form>
				
				<div class="login-link">
					<span> Already have an account? <a href="login.php"> Login now </a> </span>
				</div>
			</div>
		</div>

<?php
    include('connect.php');

    if(isset($_POST['btnRegister'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
		$email = $_POST['emailadd'];
		$password = $_POST['password'];
		$confirmedpassword = $_POST['confirmpassword'];
	
		// Check if the passwords match
		if($password!= $confirmedpassword) {
			$error_passwords_do_not_match = "Passwords do not match.";
			echo $error_passwords_do_not_match;
		} else {
			// Check if username and email already exist
			$sql_username = "SELECT * FROM tbluseraccount WHERE username='".$username."'";
			$sql_email = "SELECT * FROM tbluseraccount WHERE emailadd='".$email."'";
			
			$user_result = mysqli_query($connection, $sql_username);
			$email_result = mysqli_query($connection, $sql_email);
			
			$user_row = mysqli_num_rows($user_result);
			$email_row = mysqli_num_rows($email_result);
			
			if($user_row == 0 && $email_row == 0){
				// Save data to tbluseraccount    
				$hashed_password = password_hash($password, PASSWORD_BCRYPT);
	
				$sql_insert_account = "INSERT INTO tbluseraccount (username, emailadd, password) VALUES ('".$username."', '".$email."', '".$hashed_password."')";
				mysqli_query($connection, $sql_insert_account);
	
				// Get the ID of the last inserted record in tbluseraccount
				$acctid = mysqli_insert_id($connection);
	
				// Save data to tbluserprofile with the acctid foreign key
				$sql_insert_profile = "INSERT INTO tbluserprofile (firstname, lastname, acctid) VALUES ('".$firstname."', '".$lastname."', '".$acctid."')";
				mysqli_query($connection, $sql_insert_profile);
	
				$_SESSION['success'] = "Registration successful.";
				header('location: login.php');
				exit;
			} else {
				if($user_row!= 0) {
					$error_username_exists = "Username already exists.";
					echo $error_username_exists;
				} else {
					$error_email_exists = "Email already exists.";
					echo $error_email_exists;
				}
			}
		}
	}
?>


	</body> 

</html>
