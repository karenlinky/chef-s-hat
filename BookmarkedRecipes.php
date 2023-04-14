<?php
session_start();
require_once 'Config.php';
require_once 'SearchBar.php';
require_once 'GetBookmarkedRecipes.php';
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: Login.php");
	exit;
}

$username = $_SESSION['uid'];
$recipes = getBookmarkedRecipes($username);

echo '<script>let Recipes = ' . json_encode($recipes) . ';</script>';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Chef's Hat | Bookmarks</title>
		<link rel="stylesheet" href="Header.css">
		<link rel="stylesheet" href="RecipeShowcase.css">
	</head>
	<body onload="loadHeaderAndMenu();loadRecipes('Bookmarks');">
		<div id="wrapper"></div>
		<script src="Header.js"></script>
		<script src="Menu.js"></script>
		<script src="StartPage.js"></script>
	</body>
</html>