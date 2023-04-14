<?php
require_once 'Config.php';

// The login system takes https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php as a reference

$username = $password = $confirm_password = '';
$username_err = $password_err = $confirm_password_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (empty($username)) {
		$username_err = 'Please enter your username';
	} else {
		$sql = 'SELECT UserID FROM Users WHERE UserID = ?';
		
		$stmt = $conn->prepare($sql);
		if ($stmt) {
			$stmt->bind_param('s', $un);
			$un = $username;
			
			if ($stmt->execute()) {
				$stmt->store_result();
				
				if ($stmt->num_rows == 1) {
					$username_err = 'This username is already taken.';
				}
			}
			$stmt->close();
		} else {
			echo 'Something went wrong.';
		}
	}
	
	if (empty($password) || strlen($password) < 6) {
		$password_err = 'Please enter a combination of at least 6 characters.';	 
	}

	if (empty($confirm_password)) {
		$confirm_password_err = 'Please re-enter the password.';	 
	} else if (empty($password_err) && ($password != $confirm_password)) {
			$confirm_password_err = 'Password does not match.';
	}
	
	if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
		
		$sql = 'INSERT INTO Users (UserID, Password) VALUES (?, ?)';
		
		$stmt = $conn->prepare($sql);
		if ($stmt) {
			// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$hashedPassword = md5($password);
			$stmt->bind_param('ss', $un, $pw);
			$un = $username;
			$pw = $hashedPassword;

			if ($stmt->execute()) {
				header('location: Login.php');
			} else {
				echo 'Something went wrong.';
			}
			$stmt->close();
		}
	}
	
	$conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Chef's Hat | Register</title>
		<link rel="stylesheet" href="LoginAndRegister.css">
	</head>
	<body>
		<div id="wrapper">
			<div id="logoWrapper">
				<img id="logo" src="Logo.png">
			</div>
			<div id="formWrapper">
				<div id="siteName">Chef's Hat</div>
				<div id="instruction">Sign Up</div>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="field">
						<label>Username</label>
						<input type="text" name="username" placeholder="username" value="<?php echo $username; ?>">
						<span class="loginInvalidOutput"><?php echo $username_err; ?></span>
					</div>
					<div class="field">
						<label>Password</label>
						<input type="password" name="password" placeholder="password" value="<?php echo $password; ?>">
						<span class="loginInvalidOutput"><?php echo $password_err; ?></span>
					</div>
					<div class="field">
						<label>Confirm Password</label>
						<input type="password" name="confirm_password" placeholder="re-enter password" value="<?php echo $confirm_password; ?>">
						<span class="loginInvalidOutput"><?php echo $confirm_password_err; ?></span>
					</div>
					<div class="field">
						<input type="submit" value="Create account">
					</div>
					<div>Already have an account? <a href="Login.php">Login here</a></div>
				</form>
			</div>
		</div>
		<!-- <script src=""></script> -->
	</body>
</html>