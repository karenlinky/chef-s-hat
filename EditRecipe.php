<?php
// session_start();
require_once 'Config.php';
require_once 'SearchBar.php';
require_once 'GetRecipe.php';
require_once 'UpdateRecipe.php';
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: Login.php");
    exit;
}

if (!isset($_GET['rid'])) {
	header("location: EditRecipe.php?rid=new");
}

$username = $_SESSION['uid'];
$rid = $_GET['rid'];
$recipe = getRecipe($rid, $username);

if ($recipe['recipeExists']) {
	if (!$recipe['author']['isUser']) {
		header('location: EditRecipe.php?rid=new');
	}
}
echo '<script>let Recipe = ' . json_encode($recipe) . ';</script>';
	// echo '<script>alert(' . json_encode($_POST) . ');</script>';

$title = $recipeDay = $recipeHour = $recipeMin = $ingredients = $method = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipe'])) {
	$title = $_POST['title'] ?? 'DefaultTitle';
	$recipeDay = $_POST['recipeDay'] != "" ? $_POST['recipeDay'] : 0;
	$recipeHour = $_POST['recipeHour'] != "" ? $_POST['recipeHour'] : 0;
	$recipeMin = $_POST['recipeMin'] != "" ? $_POST['recipeMin'] : 0;
	
	
	$ingredients = [];
	foreach($_POST as $name => $value) {
		$ingredient = [];
	    $substrings = explode("_", $name);
	    if ($substrings[0] == 'Ingredient' && !is_null($value) && $value != '') {
	        $number = $substrings[1];
	        $ingredient['ingredient'] = $value;
	        $ingredient['quantity'] = $_POST['Quantity_' . $substrings[1]] ?? '';
	    	array_push($ingredients, $ingredient);
	    }
	}
	
	$method = [];
	foreach($_POST as $name => $value) {
	    $substrings = explode("_", $name);
	    if ($substrings[0] == 'Method' && !is_null($value) && $value != '') {
	    	array_push($method, $value);
	    }
	}
	updateRecipe($rid, $username, $title, $recipeDay, $recipeHour, $recipeMin, $ingredients, $method);
}
// echo '<script>alert('.$rid. ')</script>';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Chef's Hat | Edit</title>
		<link rel="stylesheet" href="Header.css">
		<link rel="stylesheet" href="Recipe.css">
	</head>
	<body onload="loadHeaderAndMenu();loadRecipeForEditing();">
		<div id="wrapper">
			<form id="recipeWrapper" method="POST">
				<input style="display:none" name="rid" value="">
				<input id="textTitle" class="recipeInput" type="text" name="title" value="" placeholder="Title">
				<div class="recipeSection">
					<div class="sectionHeader">Time</div>
					<input id="recipeDay" type="number" name="recipeDay" value="" placeholder="0" min="0" class="recipeDuration">d
					<input id="recipeHour" type="number" name="recipeHour" value="" placeholder="0" min="0" max="24" class="recipeDuration">h
					<input id="recipeMin" type="number" name="recipeMin" value="" placeholder="0" min="0" max="60" class="recipeDuration">min
				</div>
				<div class="recipeSection">
					<div class="sectionHeader">Ingredients</div>
					<!-- <textarea id="textIngredients" name="ingredients" class="recipeTextArea"></textarea> -->
					<table id="editIngredients">
						<tbody>
							<tr>
								<th>Ingredient</th>
								<th>Quantity</th>
							</tr>
<!-- 							<tr class="ingredientRow" ingredientNumber="1">
								<td><input type="text" name="Ingredient_1" class="recipeTextArea ingredient"></td>
								<td><input type="text" name="Quantity_1" class="recipeTextArea quantity"></td>
								<td class="ingredientsMethodButton"><span class="ingredientsMethodButtonText ingredientsAddButtonText" onclick="addIngredient(this)">+</span></td>
								<td class="ingredientsMethodButton"><span class="ingredientsMethodButtonText ingredientsRemoveButtonText" onclick="removeIngredient(this)" style="display:none">-</span></td>
							</tr> -->
							<colgroup>
								<col id="editIngredientsCol1"></col>
								<col id="editIngredientsCol2"></col>
								<col id="editIngredientsCol3"></col>
								<col id="editIngredientsCol4"></col>
							</colgroup>
						</tbody>
					</table>
				</div>
				<div class="recipeSection">
					<div class="sectionHeader">Method</div>
					<!-- <textarea id="textMethod" name="method" class="recipeTextArea"></textarea> -->
					<table id="editMethod">
						<tbody>
							<!-- <tr class="methodRow" methodNumber="1">
								<td class="methodNumber">1</td>
								<td><input type="text" name="Method_1" class="recipeTextArea method"></td>
								<td class="ingredientsMethodButton"><span class="ingredientsMethodButtonText methodAddButtonText" onclick="addMethod(this)">+</span></td>
								<td class="ingredientsMethodButton"><span class="ingredientsMethodButtonText methodRemoveButtonText" onclick="removeMethod(this)" style="display:none">-</span></td>
							</tr> -->
							<colgroup>
								<col id="editMethodCol1"></col>
								<col id="editMethodCol2"></col>
								<col id="editMethodCol3"></col>
								<col id="editMethodCol4"></col>
							</colgroup>
						</tbody>
					</table>
				</div>
				<button id="saveButtonWrapper" type="submit" name="recipe">
					<div id="saveButton">Save</div>
				</button>
			</form>
		</div>
		<script src="Header.js"></script>
		<script src="Menu.js"></script>
		<script src="ManageEditIngredientsMethod.js"></script>
		<script src="StartPage.js"></script>
	</body>
</html>

