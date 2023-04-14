<?php
require_once 'Config.php';

// The login system takes https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php as a reference

$username = $password = '';
$username_err = $password_err = $login_err = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (empty($username)) {
		$username_err = 'Please enter your username.';
	}
	
	if (empty($password)) {
		$password_err = 'Please enter your password.';	 
	}

	if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = 'SELECT UserID, Password FROM Users WHERE UserID = ?';
        
        $stmt = $conn->prepare($sql);
        if($stmt){
            $stmt->bind_param("s", $un);
            
            $un = $username;
            
            if($stmt->execute()){
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $stmt->bind_result($username, $hashed_password);
                    if($stmt->fetch()){
                        // if(password_verify($password, $hashed_password) || $password == $hashed_password){
                        if(md5($password) == $hashed_password){
                            session_start();
                            
                            $_SESSION['loggedin'] = true;
                            $_SESSION['uid'] = $username;                           
                            
                            header('location: Home.php');
                        } else{
                            $login_err = 'Invalid username or password.';
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = 'Invalid username or password.';
                }
            } else{
                echo 'Something went wrong.';
            }

            // Close statement
            $stmt->close();
        }
    }

	// $id = 1;
	// session_start();
	// $_SESSION['loggedin'] = true;
 //    $_SESSION['uid'] = $id;

 //    header('location: Home.php');
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Chef's Hat | Login</title>
		<link rel="stylesheet" href="LoginAndRegister.css">
	</head>
	<body>
		<div id="wrapper">
			<div id="logoWrapper">
				<img id="logo" src="Logo.png">
			</div>
			<div id="formWrapper">
				<div id="siteName">Chef's Hat</div>
				<div id="instruction">Login</div>
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
						<span class="loginInvalidOutput"><?php echo $login_err; ?></span>
					</div>
					<div class="field">
						<input type="submit"value="Login">
					</div>
					<div>Doesn't have an account? <a href="Register.php">Create new account</a></div>
				</form>
			</div>
		</div>
		<!-- <script src=""></script> -->
	</body>
</html>