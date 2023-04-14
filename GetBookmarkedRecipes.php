<?php
function getBookmarkedRecipes($username) {
	$sql = 'SELECT RecipeID FROM Bookmarks WHERE UserID = \'' . $username . '\'';

	$recipes = [];

	global $conn;
	$result = $conn->query($sql);
	while ($row = $result->fetch_array()) {		
		$recipe = [];
		$rid = $row['RecipeID'];
		$recipe['rid'] = $rid;
		$recipeSql = 'SELECT * FROM Recipes WHERE RecipeID = ' . $rid;
		$recipeResult = $conn->query($recipeSql)->fetch_array();

		$recipe['title'] = $recipeResult['Name'];
		$recipe['author'] = $recipeResult['Author'];
		$recipe['time'] = $recipeResult['PrepTime'];

		$ratingSQL = 'SELECT AVG(Rating) AS Rating FROM Reviews WHERE RecipeID = ' . $rid;
		$ratingResult = $conn->query($ratingSQL)->fetch_array();
		$recipe['ratings'] = round($ratingResult['Rating']);
		array_push($recipes, $recipe);
	}

	return $recipes;

	// $uid = $_SESSION['uid'];

	// $recipes = [
	//	 [
	//		 'rid' => 6,
	//		 'title' => 'Baked Salmon',
	//		 'author' => 'Dummy2',
	//		 'time' => '45',
	//		 'ratings' => 1
	//	 ],
	//	 [
	//		 'rid' => 7,
	//		 'title' => 'Banana Split',
	//		 'author' => 'Dummy3',
	//		 'time' => '30',
	//		 'ratings' => 4
	//	 ],
	//	 [
	//		 'rid' => 8,
	//		 'title' => 'Tiramisu',
	//		 'author' => 'Dummy2',
	//		 'time' => '120',
	//		 'ratings' => 3
	//	 ],
	//	 [
	//		 'rid' => 9,
	//		 'title' => 'Poke Bowl',
	//		 'author' => 'Dummy4',
	//		 'time' => '40',
	//		 'ratings' => 5
	//	 ],
	//	 [
	//		 'rid' => 10,
	//		 'title' => 'Guacamole',
	//		 'author' => 'Dummy5',
	//		 'time' => '20',
	//		 'ratings' => 1
	//	 ],
	//	 [
	//		 'rid' => 11,
	//		 'title' => 'Hot Wings',
	//		 'author' => 'Dummy5',
	//		 'time' => '60',
	//		 'ratings' => 3
	//	 ],
	//	 [
	//		 'rid' => 12,
	//		 'title' => 'Kimchi',
	//		 'author' => 'Dummy3',
	//		 'time' => '45',
	//		 'ratings' => 5
	//	 ],
	//	 [
	//		 'rid' => 13,
	//		 'title' => 'Mac and cheese',
	//		 'author' => 'Dummy5',
	//		 'time' => '45',
	//		 'ratings' => 2
	//	 ]
	// ];

	// echo '<script>let Recipes = ' . json_encode($recipes) . ';</script>';
}
?>