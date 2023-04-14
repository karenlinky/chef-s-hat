const Body = document.getElementsByTagName("body")[0];
const MaxRating = 5;
const ratedStar = "&#11088";
const emptyStar = "&#x2606";
function loadHeaderAndMenu()
{
	Body.innerHTML = `<div id="header">
			<a id="logoWrapper" href="Home.php"><img id="logo" src="Logo.png"></a>
			<form id="searchBarWrapper" method="POST"><input id="searchBar" type="text" name="search_query" placeholder="Search"></form>
		</div>
		<div id="menuWrapper">
				<div id="menu">
					<a class="menuButtonHyperlink" href="Home.php"><div class="menuButton">My Recipes</div></a>
					<a class="menuButtonHyperlink" href="EditRecipe.php?rid=new"><div class="menuButton">Create Recipe</div></a>
					<a class="menuButtonHyperlink" href="BookmarkedRecipes.php?"><div class="menuButton">Bookmarks</div></a>
					<a class="menuButtonHyperlink" href="Logout.php"><div class="menuButton">Logout</div></a>
				</div>
		</div>
		<div id="menuToggleButton" onclick="showHideSideMenu()">
			<div class="menuButtonBar"></div>
			<div class="menuButtonBar"></div>
			<div class="menuButtonBar"></div>
		</div>
		<div id="menuOverlay" onclick="showHideSideMenu()"></div>` + Body.innerHTML;
}


function getTimeFromMin(min) {
	let hour = Math.floor(min/60);
	let day = Math.floor(hour/24);
	hour -= 24 * day;
	min -= (60 * hour + 24 * 60 * day);

	return {"day": day, "hour": hour, "min": min};
}