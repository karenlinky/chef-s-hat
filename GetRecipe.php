<?php

function getRecipe($rid, $username) {

	if (is_null($rid) || $rid == 0 || !is_numeric($rid)) {
		return [
			'recipeExists' => false
		];
	}

	global $conn;
	$sql = 'SELECT * FROM Recipes WHERE RecipeID = ' . $rid;
	$result = $conn->query($sql)->fetch_array();

	if (!$result) {
		return [
			'recipeExists' => false
		];
	}

	$title = $result['Name'];
	$author = [
		'author' => $result['Author'],
		'isUser' => $username == $result['Author']
	];
	$prepTime = $result['PrepTime'];

	$ratingSQL = 'SELECT AVG(Rating) AS Rating FROM Reviews WHERE RecipeID = ' . $rid;
	$ratingResult = $conn->query($ratingSQL)->fetch_array();
	$ratings = round($ratingResult['Rating']);

	$userRatingSQL = 'SELECT Rating FROM Reviews WHERE RecipeID = ' . $rid . ' AND UserID = \'' . $username . '\'';
	$userRatingResult = $conn->query($userRatingSQL)->fetch_array();
	$userRating = $userRatingResult ? $userRatingResult['Rating'] : 0;

	// $title = 'Caesar Salad';
	// $author = [
	// 	'author' => 'TestUser1',
	// 	'isUser' => true
	// ];
	// $prepTime = '30';
	// $ratings = 3;
	// $userRating = 2;

	$ingredientsSQL = 'SELECT * FROM RecipeIngredients WHERE RecipeID = ' . $rid;
	$ingredientsResult = $conn->query($ingredientsSQL);
	$ingredients = [];
    while ($row = $ingredientsResult->fetch_array()) {
        $ingredient = [];
        $ingredient['ingredient'] = $row['Ingredient'];
        $ingredient['quantity'] = $row['Quantity'];
        array_push($ingredients, $ingredient);
    }

	// $ingredients = [
	// 	[
	// 		'quantity' => '5 ounces',
	// 		'ingredient' => 'Shredded Parmesan cheese'
	// 	],
	// 	[
	// 		'quantity' => '3',
	// 		'ingredient' => 'lettuce'
	// 	],
	// 	[
	// 		'quantity' => '',
	// 		'ingredient' => 'Caesar salad dressing'
	// 	],
	// 	[
	// 		'quantity' => '1',
	// 		'ingredient' => 'baguette'
	// 	],
	// 	[
	// 		'quantity' => '',
	// 		'ingredient' => 'Olive oil'
	// 	]
	// ];

    global $recipeDirectionSeparator;
	$method = explode($recipeDirectionSeparator, $result['Directions']);

	// $method = [
	// 	'Cut baguette into pieces and spray it with olive oil. Broil till it turns light brown.',
	// 	'Tear off lettuce into smaller pieces',
	// 	'Mix the baguette, cheese, salad dressing and lettuce together'
	// ];

	$bookmarkedSQL = 'SELECT COUNT(*) AS Count FROM Bookmarks WHERE RecipeID = ' . $rid . ' AND UserID = \'' . $username . '\'';
	$bookmarkedResult = $conn->query($bookmarkedSQL)->fetch_array()['Count'];
	$bookmarked = $bookmarkedResult == 1;

	return [
		'recipeExists' => true,
		'rid' => $rid,
		'title' => $title,
		'author' => $author,
		'prepTime' => $prepTime,
		'ratings' => $ratings,
		'userRating' => $userRating,
		'ingredients' => $ingredients,
		'method' => $method,
		'bookmarked' => $bookmarked
	];
}
?>