<?php
session_start();
require_once 'Config.php';
function updateRecipe($rid, $username, $title, $recipeDay, $recipeHour, $recipeMin, $ingredients, $method) {
    $prepTime = $recipeDay * 24 * 60 + $recipeHour * 60 + $recipeMin;
    $type = 'type5';
    $currentDate = date("Y-m-d");
    global $recipeDirectionSeparator;
    $method = implode($recipeDirectionSeparator, $method);

    global $conn;
    if (is_null($rid) || $rid == 0 || !is_numeric($rid)) {
        $sql = 'INSERT INTO Recipes (Name, SubmitDate, PrepTime, Type, Directions, FlagInactive, Author) VALUES (\'' . $title . '\', \'' . $currentDate . '\', ' . $prepTime . ', \'' . $type . '\', \'' . $method . '\', ' . 0 . ', \'' . $username . '\')';
        $conn->query($sql);
        $rid = $conn->insert_id;
    } else {
        $sql = 'UPDATE Recipes SET Name = \'' . $title . '\', ' .
        'SubmitDate = \'' . $currentDate . '\', ' .
        'PrepTime = ' . $prepTime . ', ' .
        'Type = \'' . $type . '\', ' .
        'Directions = \'' . $method . '\' ' .
        'WHERE RecipeID = ' . $rid;
        $conn->query($sql);
    }

    $conn->query('DELETE FROM RecipeIngredients WHERE RecipeID = ' . $rid);
    for ($i = 0; $i < count($ingredients); $i++) {
        $ingredientSQL = 'INSERT INTO RecipeIngredients (RecipeID, Ingredient, Quantity) VALUES (' . $rid . ', \'' . $ingredients[$i]['ingredient'] . '\', \'' . $ingredients[$i]['quantity'] . '\')';
        $conn->query($ingredientSQL);
    }

    header('location: EditRecipe.php?rid=' . $rid);
}
?>