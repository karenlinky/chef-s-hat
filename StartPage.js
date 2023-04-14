function loadRecipes(title)
{
	let Wrapper = document.getElementById("wrapper");

	let PageTitle = document.createElement("div");
	PageTitle.id = "pageTitle";
	PageTitle.innerHTML = title;
	Wrapper.appendChild(PageTitle);

	// let RecipesContainer = document.createElement("form");
	// RecipesContainer.id = "recipesContainer";
	// RecipesContainer.method = "POST";

	let RecipesContainer = document.createElement("div");
	RecipesContainer.id = "recipesContainer";

	// recipes is defined in getMyRecipes() in getMyRecipes.php
	let numRecipes = Recipes.length;

	if (numRecipes == 0) {
		let NoRecipeMessage = document.createElement("div");
		let message = title == "My Recipes" ?
			"You do not have any recipes yet. Click \"Create Recipe\" from the menu to create one!" :
			title == "Bookmarks" ?
			"You do not have any Bookmarked recipes." :
			title == "Search Result" ?
			"No results found. Try using a different keyword!" :
			"";
		NoRecipeMessage.innerHTML = message;
		NoRecipeMessage.classList.add("NoRecipeMessage");
		RecipesContainer.appendChild(NoRecipeMessage);
	} else {
		for (let i = 0; i < numRecipes; i++) {
			// let RecipeLink = document.createElement("button");
			// // RecipeLink.href = "Home.php";
			// RecipeLink.classList.add("recipeButton");
			// RecipeLink.name = "rid" + Recipes[i]["rid"];
			// RecipeLink.type = "submit"

			let RecipeLink = document.createElement("a");
			RecipeLink.href = "Recipe.php?rid=" + Recipes[i]["rid"];
			RecipeLink.setAttribute("ratings",Recipes[i]["ratings"]);
			RecipeLink.setAttribute("time",Recipes[i]["time"]);
			RecipeLink.classList.add("recipeButton");

			let Recipe = document.createElement("div");
			Recipe.classList.add("recipe");
			RecipeLink.appendChild(Recipe);

			let RecipeTitle = document.createElement("div");
			RecipeTitle.classList.add("recipeTitle")
			RecipeTitle.innerHTML = Recipes[i]["title"];
			Recipe.appendChild(RecipeTitle);

			let RecipeAuthor = document.createElement("div");
			RecipeAuthor.classList.add("recipeInfo")
			RecipeAuthor.innerHTML = Recipes[i]["author"];
			Recipe.appendChild(RecipeAuthor);

			let RecipeTime = document.createElement("div");

			let day = getTimeFromMin(Recipes[i]["time"])["day"];
			let hour = getTimeFromMin(Recipes[i]["time"])["hour"];
			let min = getTimeFromMin(Recipes[i]["time"])["min"];

			RecipeTime.innerHTML = day > 0 ? day + "d " : "";
			RecipeTime.innerHTML += day > 0 || hour > 0 ? hour + "h " : "";
			RecipeTime.innerHTML += min + "min";

			RecipeTime.classList.add("recipeInfo")
			Recipe.appendChild(RecipeTime);

			let RecipeRating = document.createElement("div");
			RecipeRating.classList.add("recipeInfo");
			RecipeRating.innerHTML = "";
			for (let j = 0; j < MaxRating; j++)
			{
				RecipeRating.innerHTML += j < Recipes[i]["ratings"] ? ratedStar : emptyStar;
			}
			Recipe.appendChild(RecipeRating);

			RecipeLink.appendChild(Recipe)
			RecipesContainer.appendChild(RecipeLink);
		}
	}

	Wrapper.appendChild(RecipesContainer);
}

function loadRecipe()
{
	let Wrapper = document.createElement("div");
	Wrapper.id = "wrapper";

	let ToolsContainer = document.createElement("div");
	ToolsContainer.id = "ToolsContainer";

	RatingWrapper = document.createElement("form");
	RatingWrapper.id = "ratingWrapper";
	RatingWrapper.classList.add("toolWrapper");
	RatingWrapper.method = "POST";

	for (let i = 1; i <= MaxRating; i++) {
		RatingStar = document.createElement("button");
		RatingStar.id = "star" + i;
		RatingStar.type = "submit";
		RatingStar.name = "star" + i;
		RatingStar.classList.add("ratingStar");
		RatingStar.innerHTML = i <= Recipe['userRating'] ? ratedStar : emptyStar;
		RatingWrapper.appendChild(RatingStar);
	}
	
	ToolsContainer.appendChild(RatingWrapper);

	BookmarkWrapper = document.createElement("form");
	BookmarkWrapper.classList.add("toolWrapper");
	BookmarkWrapper.method = "POST";

	BookmarkButtonWrapper = document.createElement("button");
	BookmarkButtonWrapper.id = "BookmarkButtonWrapper";

	BookmarkButton = document.createElement("button");
	BookmarkButton.type = "submit";
	BookmarkButton.name = "bookmark";
	BookmarkButton.innerHTML = Recipe['bookmarked'] ? "Remove Bookmark" : "Bookmark";
	BookmarkButton.id = "BookmarkButton";
	BookmarkButtonWrapper.appendChild(BookmarkButton);

	BookmarkWrapper.appendChild(BookmarkButtonWrapper);

	ToolsContainer.appendChild(BookmarkWrapper);

	// let EditButton = document.createElement("a");
	// EditButton.href = "";
	// EditButton.id = "editButton";
	// EditButton.innerHTML = "&#128397";
	// EditButton.classList.add("toolWrapper")
	// ToolsContainer.appendChild(EditButton);

	Wrapper.appendChild(ToolsContainer);

	let RecipeWrapper = document.createElement("div");
	RecipeWrapper.id = "recipeWrapper";

	if (Recipe["author"]["isUser"]) {
		let EditWrapper = document.createElement("div");
		EditWrapper.id = "editWrapper";

		let EditButton = document.createElement("a");
		EditButton.href = "EditRecipe.php?rid=" + Recipe["rid"];
		EditButton.id = "editButton";
		EditButton.innerHTML = "&#128397";

		EditWrapper.appendChild(EditButton);

		RecipeWrapper.appendChild(EditWrapper);
	}

	let RecipeTitle = document.createElement("div");
	RecipeTitle.id = "recipeTitle";
	RecipeTitle.innerHTML = Recipe["title"];
	RecipeWrapper.appendChild(RecipeTitle);

	let RecipeAuthor = document.createElement("div");
	RecipeAuthor.innerHTML = Recipe["author"]["author"];
	RecipeAuthor.id = "recipeAuthor";
	RecipeAuthor.classList.add("recipeInfo");
	RecipeWrapper.appendChild(RecipeAuthor);

	let RecipePrepTime = document.createElement("div");

	let day = getTimeFromMin(Recipe["prepTime"])["day"];
	let hour = getTimeFromMin(Recipe["prepTime"])["hour"];
	let min = getTimeFromMin(Recipe["prepTime"])["min"];

	RecipePrepTime.innerHTML = "Time: ";
	RecipePrepTime.innerHTML += day > 0 ? day + "d " : "";
	RecipePrepTime.innerHTML += day > 0 || hour > 0 ? hour + "h " : "";
	RecipePrepTime.innerHTML += min + "min";

	RecipePrepTime.classList.add("recipeInfo");
	RecipeWrapper.appendChild(RecipePrepTime);

	let RecipeRatings = document.createElement("div");
	RecipeRatings.innerHTML = "Ratings: ";
	for (let i = 0; i < MaxRating; i++)
	{
		RecipeRatings.innerHTML += i < Recipe['ratings'] ? ratedStar : emptyStar;
	}
	RecipeRatings.classList.add("recipeInfo");
	RecipeWrapper.appendChild(RecipeRatings);

	let IngredientWrapper = document.createElement("div");
	IngredientWrapper.classList.add("recipeSection");

	let IngredientHeader = document.createElement("div");
	IngredientHeader.innerHTML = "Ingredients";
	IngredientHeader.classList.add("sectionHeader");
	IngredientWrapper.appendChild(IngredientHeader);

	// let Ingredients = document.createElement("ul");
	// Ingredients.innerHTML = "";
	// for (let i = 0; i < Recipe["ingredients"].length; i++) {
	// 	Ingredients.innerHTML += "<li>" + Recipe["ingredients"][i]["quantity"] + " " + Recipe["ingredients"][i]["ingredient"] + "</li>";
	// }
	// Ingredients.classList.add("recipeSteps");
	// IngredientWrapper.appendChild(Ingredients);

	let Ingredients = document.createElement("table");
	Ingredients.id = "ingredients";
	IngredientContent = "<tbody><tr><th>Ingredient</th><th>Quantity</th></tr>";
	for (let i = 0; i < Recipe["ingredients"].length; i++) {
		IngredientContent += "<tr><td>" + Recipe["ingredients"][i]["ingredient"] + "</td><td>" + Recipe["ingredients"][i]["quantity"] + "</td></tr>";
	}
	IngredientContent += "</tbody>";
	Ingredients.innerHTML = IngredientContent;
	Ingredients.classList.add("recipeSteps");

	let IngredientsCol = document.createElement("colgroup");
	let IngredientsCol1 = document.createElement("col");
	IngredientsCol1.id = "IngredientsCol1";
	let IngredientsCol2 = document.createElement("col");
	IngredientsCol2.id = "IngredientsCol2";
	IngredientsCol.appendChild(IngredientsCol1);
	IngredientsCol.appendChild(IngredientsCol2);
	Ingredients.appendChild(IngredientsCol);

	IngredientWrapper.appendChild(Ingredients);

	RecipeWrapper.appendChild(IngredientWrapper);

	let MethodWrapper = document.createElement("div");
	MethodWrapper.classList.add("recipeSection");

	let MethodHeader = document.createElement("div");
	MethodHeader.innerHTML = "Method";
	MethodHeader.classList.add("sectionHeader");
	MethodWrapper.appendChild(MethodHeader);

	let Method = document.createElement("ol");
	Method.id = "method";
	Method.innerHTML = "";
	for (let i = 0; i < Recipe["method"].length; i++) {
		Method.innerHTML += "<li>" + Recipe["method"][i] + "</li>";
	}
	Method.type = 1;
	Method.classList.add("recipeSteps");
	MethodWrapper.appendChild(Method);

	RecipeWrapper.appendChild(MethodWrapper);

	Wrapper.appendChild(RecipeWrapper);

	Body.appendChild(Wrapper);	// body is defined in Header.js
}

function loadRecipeForEditing()
{
	// if (!Recipe["recipeExists"]) {
	// 	return;
	// }

	if (Recipe["recipeExists"]) {
		document.getElementById("textTitle").value = Recipe["title"];

		document.getElementById("recipeDay").value = getTimeFromMin(Recipe["prepTime"])["day"];
		document.getElementById("recipeHour").value = getTimeFromMin(Recipe["prepTime"])["hour"];
		document.getElementById("recipeMin").value = getTimeFromMin(Recipe["prepTime"])["min"];
	}



	// document.getElementById("textIngredients").value = "";
	// for (let i = 0; i < Recipe["ingredients"].length; i++) {
	// 	document.getElementById("textIngredients").value += Recipe["ingredients"][i] + "\n";
	// }

	// let Ingredients = document.createElement("table");
	// Ingredients.id = "ingredients";
	// IngredientContent = "<tbody><tr><th>Ingredient</th><th>Quantity</th></tr>";
	// for (let i = 0; i < Recipe["ingredients"].length; i++) {
	// 	IngredientContent += "<tr><td>" + Recipe["ingredients"][i]["ingredient"] + "</td><td>" + Recipe["ingredients"][i]["quantity"] + "</td></tr>";
	// }
	// IngredientContent += "</tbody>";
	// Ingredients.innerHTML = IngredientContent;
	// Ingredients.classList.add("recipeSteps");

	let numIngredients = Recipe["recipeExists"] ? Recipe["ingredients"].length : 0;
	let IngredientTable = document.getElementById("editIngredients");
	let IngredientTableBody = IngredientTable.getElementsByTagName("tbody")[0];
	let IngredientColGroup = IngredientTableBody.getElementsByTagName("colgroup")[0];

	if (numIngredients == 0) {
		let NewRow = getIngredientRow(1);
		IngredientTableBody.insertBefore(NewRow, IngredientColGroup);
		fixIngredientNumbers();
	} else {
		for (let i = 0; i < numIngredients; i++) {
			let NewRow = getIngredientRow(i + 1);
			IngredientTableBody.insertBefore(NewRow, IngredientColGroup);
			let Ingredient = NewRow.getElementsByClassName("ingredient")[0];
			Ingredient.value = Recipe["ingredients"][i]["ingredient"];
			let Quantity = NewRow.getElementsByClassName("quantity")[0];
			Quantity.value = Recipe["ingredients"][i]["quantity"];
		}
		fixIngredientNumbers();
	}


	// document.getElementById("textMethod").value = "";
	// for (let i = 0; i < Recipe["method"].length; i++) {
	// 	document.getElementById("textMethod").value += Recipe["method"][i] + "\n";
	
	let numMethod = Recipe["recipeExists"] ? Recipe["method"].length : 0;
	let MethodTable = document.getElementById("editMethod");
	let MethodTableBody = MethodTable.getElementsByTagName("tbody")[0];
	let MethodColGroup = MethodTableBody.getElementsByTagName("colgroup")[0];

	if (numMethod == 0) {
		let NewRow = getMethodRow(1);
		MethodTableBody.insertBefore(NewRow, MethodColGroup);
		fixMethodNumbers();
	} else {
		for (let i = 0; i < numMethod; i++) {
			let NewRow = getMethodRow(i + 1);
			MethodTableBody.insertBefore(NewRow, MethodColGroup);
			let Method = NewRow.getElementsByClassName("method")[0];
			Method.value = Recipe["method"][i];
		}
		fixMethodNumbers();
	}
	// }
}