<?php
session_start();
require_once 'Config.php';
require_once 'SearchBar.php';
require_once 'GetRecipe.php';
require_once 'UpdateRatings.php';
require_once 'ToggleBookmark.php';
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: Login.php");
	exit;
}

if (!isset($_GET['rid'])) {
	header("location: Home.php");
}

$username = $_SESSION['uid'];
$rid = $_GET['rid'];
// echo '<script>alert('.$rid. ')</script>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (substr(array_key_first($_POST), 0, 4) == 'star') {
		$numStar = substr(array_key_first($_POST), 4);
		updateRatings($rid, $username, $numStar);
	} else if (array_key_first($_POST) == 'bookmark') {
		toggleBookmark($rid, $username);
	}
}

$recipe = getRecipe($rid, $username);
echo '<script>let Recipe = ' . json_encode($recipe) . ';</script>';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Chef's Hat | Recipe</title>
		<link rel="stylesheet" href="Header.css">
		<link rel="stylesheet" href="Recipe.css">
	</head>
	<body onload="loadHeaderAndMenu();loadRecipe();">
		<script src="Header.js"></script>
		<script src="Menu.js"></script>
		<script src="StartPage.js"></script>
	</body>
</html>

