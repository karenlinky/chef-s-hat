<?php
	$servername = '127.0.0.1';
	$username = 'UserJKN';
	$password = 'PasswordJKN';
	$dbname = 'Recipes';
 
$conn = new mysqli($servername, $username, $password, $dbname);

$recipeDirectionSeparator = '[SEPERATOR]';
 
if($conn === false){
    die('ERROR: Connection failed: ' . $conn->connect_error);
}
?>