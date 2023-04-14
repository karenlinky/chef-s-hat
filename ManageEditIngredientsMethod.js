function getIngredientRow(ingredientNumber) {
	Row = document.createElement("tr");
	Row.classList.add("ingredientRow");
	Row.setAttribute("ingredientNumber", ingredientNumber);

	Ingredient = document.createElement("td");
	IngredientText = document.createElement("input");
	IngredientText.type = "text";
	IngredientText.name = "Ingredient_" + ingredientNumber;
	IngredientText.classList.add("recipeTextArea");
	IngredientText.classList.add("ingredient");
	Ingredient.appendChild(IngredientText);
	Row.appendChild(Ingredient);

	Quantity = document.createElement("td");
	QuantityText = document.createElement("input");
	QuantityText.type = "text";
	QuantityText.name = "Quantity_" + ingredientNumber;
	QuantityText.classList.add("recipeTextArea");
	QuantityText.classList.add("quantity");
	Quantity.appendChild(QuantityText);
	Row.appendChild(Quantity);

	PlusButton = document.createElement("td");
	PlusButton.classList.add("ingredientsMethodButton");

	PlusButtonText = document.createElement("span");
	PlusButtonText.classList.add("ingredientsMethodButtonText");
	PlusButtonText.classList.add("ingredientsAddButtonText");
	PlusButtonText.onclick = function(){addIngredient(this)};
	PlusButtonText.innerHTML = "+";
	PlusButton.appendChild(PlusButtonText);
	Row.appendChild(PlusButton);

	RemoveButton = document.createElement("td");
	RemoveButton.classList.add("ingredientsMethodButton");

	RemoveButtonText = document.createElement("span");
	RemoveButtonText.classList.add("ingredientsMethodButtonText");
	RemoveButtonText.classList.add("ingredientsRemoveButtonText");
	RemoveButtonText.onclick = function(){removeIngredient(this)};
	RemoveButtonText.innerHTML = "-";
	RemoveButton.appendChild(RemoveButtonText);
	Row.appendChild(RemoveButton);

	return Row;
}

function fixIngredientNumbers() {
	Rows = document.getElementsByClassName("ingredientRow");

	for (let i = 0; i < Rows.length; i++) {
		Rows[i].setAttribute("ingredientNumber", i + 1);
		document.getElementsByClassName("ingredientsRemoveButtonText")[i].style.display = "inline";
	}

	if (Rows.length == 1) {
		document.getElementsByClassName("ingredientsRemoveButtonText")[0].style.display = "none";
	}

	Ingredients = document.getElementsByClassName("ingredient");
	for (let i = 0; i < Ingredients.length; i++) {
		let ingredientNumber = Ingredients[i].parentElement.parentElement.getAttribute("ingredientNumber");
		Ingredients[i].name = "Ingredient_" + ingredientNumber;
	}

	Quantity = document.getElementsByClassName("quantity");
	for (let i = 0; i < Quantity.length; i++) {
		let ingredientNumber = Quantity[i].parentElement.parentElement.getAttribute("ingredientNumber");
		Quantity[i].name = "Quantity_" + ingredientNumber;
	}

}


function addIngredient(ButtonPressed) {
	let Row = ButtonPressed.parentElement.parentElement;
	let IngredientNumber = parseInt(Row.getAttribute("ingredientNumber")) + 1;
	let TableBody = Row.parentElement;

	Rows = document.getElementsByClassName("ingredientRow");
	let NewRow = getIngredientRow(IngredientNumber);
	if (Rows.length >= IngredientNumber) {
		let nextChild = Rows[IngredientNumber - 1];
		TableBody.insertBefore(NewRow, nextChild);
	} else {
		TableBody.appendChild(NewRow);
	}

	fixIngredientNumbers();
}

function removeIngredient(ButtonPressed) {
	let Row = ButtonPressed.parentElement.parentElement;
	let TableBody = Row.parentElement;

	TableBody.removeChild(Row);
	fixIngredientNumbers();
}








function getMethodRow(methodNumber) {
	Row = document.createElement("tr");
	Row.classList.add("methodRow");
	Row.setAttribute("methodNumber", methodNumber);

	MethodNumberText = document.createElement("td");
	MethodNumberText.classList.add("methodNumber");
	MethodNumberText.innerHTML = methodNumber;
	Row.appendChild(MethodNumberText);

	Method = document.createElement("td");
	MethodText = document.createElement("input");
	MethodText.type = "text";
	MethodText.name = "Method_" + methodNumber;
	MethodText.classList.add("recipeTextArea");
	MethodText.classList.add("method");
	Method.appendChild(MethodText);
	Row.appendChild(Method);

	PlusButton = document.createElement("td");
	PlusButton.classList.add("ingredientsMethodButton");

	PlusButtonText = document.createElement("span");
	PlusButtonText.classList.add("ingredientsMethodButtonText");
	PlusButtonText.classList.add("methodAddButtonText");
	PlusButtonText.onclick = function(){addMethod(this)};
	PlusButtonText.innerHTML = "+";
	PlusButton.appendChild(PlusButtonText);
	Row.appendChild(PlusButton);

	RemoveButton = document.createElement("td");
	RemoveButton.classList.add("ingredientsMethodButton");

	RemoveButtonText = document.createElement("span");
	RemoveButtonText.classList.add("ingredientsMethodButtonText");
	RemoveButtonText.classList.add("methodRemoveButtonText");
	RemoveButtonText.onclick = function(){removeMethod(this)};
	RemoveButtonText.innerHTML = "-";
	RemoveButton.appendChild(RemoveButtonText);
	Row.appendChild(RemoveButton);

	return Row;
}

function fixMethodNumbers() {
	Rows = document.getElementsByClassName("methodRow");

	for (let i = 0; i < Rows.length; i++) {
		Rows[i].setAttribute("methodNumber", i + 1);
		document.getElementsByClassName("methodRemoveButtonText")[i].style.display = "inline";
	}

	if (Rows.length == 1) {
		document.getElementsByClassName("methodRemoveButtonText")[0].style.display = "none";
	}

	MethodNumber = document.getElementsByClassName("methodNumber");
	for (let i = 0; i < MethodNumber.length; i++) {
		let methodNumber = MethodNumber[i].parentElement.getAttribute("methodNumber");
		MethodNumber[i].innerHTML = methodNumber;
	}

	Method = document.getElementsByClassName("method");
	for (let i = 0; i < Method.length; i++) {
		let methodNumber = Method[i].parentElement.parentElement.getAttribute("methodNumber");
		Method[i].name = "Method_" + methodNumber;
	}

}


function addMethod(ButtonPressed) {
	let Row = ButtonPressed.parentElement.parentElement;
	let MethodNumber = parseInt(Row.getAttribute("methodNumber")) + 1;
	let TableBody = Row.parentElement;

	Rows = document.getElementsByClassName("methodRow");
	let NewRow = getMethodRow(MethodNumber);
	if (Rows.length >= MethodNumber) {
		let nextChild = Rows[MethodNumber - 1];
		TableBody.insertBefore(NewRow, nextChild);
	} else {
		TableBody.appendChild(NewRow);
	}

	fixMethodNumbers();
}


function removeMethod(ButtonPressed) {
	let Row = ButtonPressed.parentElement.parentElement;
	let TableBody = Row.parentElement;

	TableBody.removeChild(Row);
	fixMethodNumbers();
}