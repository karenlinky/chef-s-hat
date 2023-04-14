<?php
function updateRatings($rid, $username, $numStar) {
	global $conn;

	$ratedSQL = 'SELECT COUNT(*) AS Count FROM Reviews WHERE RecipeID = ' . $rid . ' AND UserID = \'' . $username . '\'';
	$ratedResult = $conn->query($ratedSQL)->fetch_array()['Count'];
	$rated = $ratedResult == 1;

	if ($rated) {
		$ratingSQL = 'SELECT Rating FROM Reviews WHERE RecipeID = ' . $rid . ' AND UserID = \'' . $username . '\'';
		$ratingResult = $conn->query($ratingSQL)->fetch_array()['Rating'];
		if ($ratingResult == $numStar) {
			$sql = 'DELETE FROM Reviews WHERE UserID = \'' . $username . '\' AND RecipeID = ' . $rid;
		} else {
			$sql = 'UPDATE Reviews SET Rating = ' . $numStar . ' WHERE UserID = \'' . $username . '\' AND RecipeID = ' . $rid;
		}
	} else {
		$sql = 'INSERT INTO Reviews (UserID, RecipeID, Rating) VALUES (\'' . $username . '\', ' . $rid . ', ' . $numStar .')';
	}
	$conn->query($sql);
}
?>