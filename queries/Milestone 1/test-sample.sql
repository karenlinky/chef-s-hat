-- Display each table

-- users

SELECT * FROM users;

-- recipes
SELECT * FROM recipes;

-- recipeIngredients
SELECT * FROM recipeIngredients;
-- bookmarks
SELECT * FROM bookmarks;
-- reviews
SELECT * FROM reviews;

-- ----------------------------------------------------------------- 
-- users

-- Does user exist (find)

SELECT COUNT(UserID) FROM users WHERE UserID = 'Person1'; -- exists
SELECT COUNT(UserID) FROM users WHERE UserID = 'Person4'; -- does not exist

-- Registering account (add account)

INSERT INTO users VALUES ('Person4', 'pass4');
SELECT * FROM users;

-- Logging in (match account + password input into user)

SELECT COUNT(UserID) FROM users WHERE UserID = 'Person2' AND Password = 'pass2'; -- match
SELECT COUNT(UserID) FROM users WHERE UserID = 'Person3'AND Password = 'pass2'; -- wrong password (no match)

-- get a list of myRecipes (only Name,Author,SubmitDate,PrepTime) 

SELECT Name, Author, SubmitDate, PrepTime 
	FROM users, recipes 
	WHERE UserID = 'Person1' AND Author = UserID; 		-- Person1's myRecipes

SELECT Name, Author, SubmitDate, PrepTime 				-- Person2's myRecipes
	FROM users, recipes 
	WHERE UserID = 'Person2' AND Author = UserID;

-- ----------------------------------------------------------------
-- recipes


-- Make new recipe (if logged in) ,user input would be(water, 1 ,type3, directions5, water, any amount)

INSERT INTO recipes VALUES (5,'water',CURDATE(),1,'type3','directions 5',0,'Person2');
INSERT INTO recipeIngredients VALUES (5,'water', 'any amount');

SELECT * FROM recipes;
SELECT * FROM recipeIngredients;

-- sort by newest (show everything)

SELECT * FROM recipes ORDER BY SubmitDate DESC;

-- sort by oldest (show everything)

SELECT * FROM recipes ORDER BY SubmitDate ASC;

-- sort by fastet preptime (show everything)

SELECT * FROM recipes ORDER BY PrepTime ASC;

-- sort by longest preptime (show everything)

SELECT * FROM recipes ORDER BY PrepTime DESC;

-- ----------------------------------------------------------------
-- recipeIngredients


-- get all ingredients (no quant) on db

SELECT Ingredient FROM recipeIngredients;

-- search by ingredient (ex. sugar), show recipe name, author, date submitted, preptime , ingredient, quantity 

SELECT Name, Author, SubmitDate, PrepTime, Ingredient, Quantity 
	FROM recipeIngredients, recipes 
		WHERE recipes.RecipeID = recipeIngredients.RecipeID AND Ingredient = 'sugar'; -- exists

SELECT Name, Author, SubmitDate, PrepTime, Ingredient, Quantity 
	FROM recipeIngredients, recipes 
		WHERE recipes.RecipeID = recipeIngredients.RecipeID AND Ingredient = 'eggs'; -- does not exist


-- ----------------------------------------------------------------
-- bookmarks


-- get a list of savedRecipes (only Title,Author,ratings,time)

-- sort by date bookmarked (oldest)

-- sort by date bookmarked (newest)

-- save recipe on bookmark

-- delete recipe on bookmark

-- ----------------------------------------------------------------
-- reviews

-- Did user already make review for this recipe
SELECT COUNT(RecipeID) FROM users, reviews WHERE users.UserID = 'Person2' AND RecipeID = 4; -- match
SELECT COUNT(RecipeID) FROM users, reviews WHERE users.UserID = 'Person2' AND RecipeID = 5; -- wrong password (no match)

-- delete review
DELETE FROM reviews WHERE UserID = 'Person3' AND RecipeID = 1;   -- delete specific review
DELETE FROM reviews WHERE UserID = 'Person1';   -- delete all reviews by user

-- Make new review
INSERT INTO reviews VALUES ('Person3',2,5);

SELECT * FROM reviews; 

-- sort recipe by rating (show Name, Rating, PrepTime, Type, Author )
SELECT Name, avgRs.AverageRating, PrepTime, Type, Author 
	FROM recipes, (SELECT RecipeID, AVG(Rating) AS AverageRating FROM reviews GROUP BY RecipeID) AS avgRs
		WHERE recipes.RecipeID = avgRs.RecipeID ORDER BY avgRs.AverageRating DESC;


-- ----------------------------------------------------------------
-- showing the end results
SELECT * FROM users;
SELECT * FROM recipes;
SELECT * FROM recipeIngredients;
SELECT * FROM bookmarks;
SELECT * FROM reviews;