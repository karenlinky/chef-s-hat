<?php
if (!empty($_POST['search_query'])) { 
	$keyword = $_POST['search_query'];
	unset($_POST['search_query']);
	header("location: SearchResult.php?search_query=" . $keyword);
}
?>