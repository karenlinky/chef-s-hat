
function updateSearchResult(){
	const RatingDropdown = document.getElementById("ratings");
	const TimeDropdown = document.getElementById("time");
	let Recipes = document.getElementsByClassName("recipeButton");

	let minRatings = Number(RatingDropdown.options[RatingDropdown.selectedIndex].value);
	let maxTime = Number(TimeDropdown.options[TimeDropdown.selectedIndex].value);

	for (let i = 0; i < Recipes.length; i++) {
		let Recipe = Recipes[i];
		Recipe.classList.remove("recipeFiltered");
		if (!isNaN(minRatings) && Recipe.getAttribute("ratings") < minRatings) {
			Recipe.classList.add("recipeFiltered");
		} else if (!isNaN(maxTime) && Recipe.getAttribute("time") > maxTime) {
			Recipe.classList.add("recipeFiltered");
		}
	}
}