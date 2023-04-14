<?php
// session_start();
require_once 'Config.php';

function toggleBookmark($rid, $username) {
	global $conn;

	$bookmarkedSQL = 'SELECT COUNT(*) AS Count FROM Bookmarks WHERE RecipeID = ' . $rid . ' AND UserID = \'' . $username . '\'';
	$bookmarkedResult = $conn->query($bookmarkedSQL)->fetch_array()['Count'];
	$bookmarked = $bookmarkedResult == 1;

	if ($bookmarked) {
		$sql = 'DELETE FROM Bookmarks WHERE RecipeID = ' . $rid . ' AND UserID = \'' . $username . '\'';
	} else {
		$currentDate = date("Y-m-d");
		$sql = 'INSERT INTO Bookmarks (RecipeID, UserID, BookmarkDate) VALUES (' . $rid . ', \'' . $username . '\', \'' . $currentDate .'\')';
	}
	$conn->query($sql);
}
?>