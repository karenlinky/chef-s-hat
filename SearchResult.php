<?php
session_start();
require_once 'Config.php';
require_once 'SearchBar.php';
require_once 'SearchRecipes.php';
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: Login.php");
	exit;
}

$keyword = $_GET['search_query'];
$recipes = searchRecipes($keyword);
echo '<script>let Recipes = ' . json_encode($recipes) . ';</script>';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Chef's Hat | Search Result</title>
		<link rel="stylesheet" href="Header.css">
		<link rel="stylesheet" href="RecipeShowcase.css">
		<link rel="stylesheet" href="SearchFilter.css">
	</head>
	<body onload="loadHeaderAndMenu();loadRecipes('Search Result');">
		<div id="wrapper">
			<div id="searchFilterWrapper">
				<select id="ratings" class="searchFilterDropdown" onchange="updateSearchResult()">
					<option value="none">Ratings...</option>
					<option value="5">&#11088&#11088&#11088&#11088&#11088</option>
					<option value="4">&#11088&#11088&#11088&#11088&#x2606 & up</option>
					<option value="3">&#11088&#11088&#11088&#x2606&#x2606 & up</option>
					<option value="2">&#11088&#11088&#x2606&#x2606&#x2606 & up</option>
					<option value="1">&#11088&#x2606&#x2606&#x2606&#x2606 & up</option>
				</select>
				<select id="time" class="searchFilterDropdown" onchange="updateSearchResult()">
					<option value="none">Time...</option>
					<option value="15">&#8804 15min</option>
					<option value="30">&#8804 30min</option>
					<option value="45">&#8804 45min</option>
					<option value="60">&#8804 1h</option>
					<option value="120">&#8804 2h</option>
					<option value="240">&#8804 4h</option>
					<option value="360">&#8804 6h</option>
					<option value="480">&#8804 8h</option>
					<option value="720">&#8804 12h</option>
					<option value="1440">&#8804 1d</option>
				</select>
			</div>
		</div>
		<script src="Header.js"></script>
		<script src="Menu.js"></script>
		<script src="StartPage.js"></script>
		<script src="SearchResult.js"></script>
	</body>
</html>