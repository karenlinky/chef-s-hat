<?php
function getMyRecipes($username) {
    $sql = 'SELECT * FROM Recipes WHERE Author = \'' . $username . '\'';

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
// $recipes = [
//     [
//         'rid' => 1,
//         'title' => 'Caesar Salad',
//         'author' => $author,
//         'time' => '30',
//         'ratings' => 3
//     ],
//     [
//         'rid' => 2,
//         'title' => 'Mango Pudding',
//         'author' => $author,
//         'time' => '120',
//         'ratings' => 5
//     ],
//     [
//         'rid' => 3,
//         'title' => 'Carbonara',
//         'author' => $author,
//         'time' => '180',
//         'ratings' => 1
//     ],
//     [
//         'rid' => 4,
//         'title' => 'Crème Brûlée',
//         'author' => $author,
//         'time' => '45',
//         'ratings' => 3
//     ],
//     [
//         'rid' => 5,
//         'title' => 'Mashed potato',
//         'author' => $author,
//         'time' => '60',
//         'ratings' => 5
//     ]
// ];
?>
