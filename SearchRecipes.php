<?php

function searchRecipes($keyword) {

	if (is_null($keyword) || $keyword == "") {
		return [];
	}

	$sql = 'SELECT * FROM Recipes WHERE LOWER(Recipes.name) LIKE LOWER(\'%' . $keyword . '%\')';

    $recipes = [];

    global $conn;
    $result = $conn->query($sql);
    while ($row = $result->fetch_array()) {
        $recipe = [];
        $rid = $row['RecipeID'];
        $recipe['rid'] = $rid;
        $recipe['title'] = $row['Name'];
        $recipe['author'] = $row['Author'];
        $recipe['time'] = $row['PrepTime'];

        $ratingSQL = 'SELECT AVG(Rating) AS Rating FROM Reviews WHERE RecipeID = ' . $rid;
        $ratingResult = $conn->query($ratingSQL);
        $recipe['ratings'] = round($ratingResult->fetch_array()['Rating']);
        array_push($recipes, $recipe);
    }

    return $recipes;
}
?>