-- Display each table

-- users

SELECT * FROM users LIMIT 10;

-- recipes
SELECT * FROM recipes LIMIT 10;

-- recipeIngredients
SELECT * FROM recipeIngredients LIMIT 10;
-- bookmarks
SELECT * FROM bookmarks LIMIT 10;
-- reviews
SELECT * FROM reviews LIMIT 10;

-- ----------------------------------------------------------------- 
-- users

-- Does user exist (find)

SELECT COUNT(UserID) FROM users WHERE UserID = 'Person1'; -- exists
SELECT COUNT(UserID) FROM users WHERE UserID = 'SampleUser1'; -- does not exist

-- Registering account (add account)

INSERT INTO users VALUES ('SampleUser1', 'password1'); -- inserted user is in a different format from sample users
SELECT * FROM users LIMIT 10;

-- Logging in (match account + password input into user)

SELECT COUNT(UserID) FROM users WHERE UserID = 'Person2' AND Password = 'pass2'; -- match
SELECT COUNT(UserID) FROM users WHERE UserID = 'Person3'AND Password = 'pass2'; -- wrong password (no match)

-- get a list of myRecipes (only Name,Author,SubmitDate,PrepTime) 

-- Create Index to improve query performance for large datasets

CREATE Index RecipeIndex ON recipes(Author); -- helps with following queries

SELECT Name, Author, SubmitDate, PrepTime 				-- Person1's myRecipes
	FROM users, recipes 
	WHERE UserID = 'Person1' AND Author = UserID
	LIMIT 10;

SELECT Name, Author, SubmitDate, PrepTime 				-- Person2's myRecipes
	FROM users, recipes 
	WHERE UserID = 'Person2' AND Author = UserID
	LIMIT 10;

-- ----------------------------------------------------------------
-- recipes


-- Make new recipe (if logged in) ,user input would be(water, 1 ,type3, directions5, water, any amount)

INSERT INTO recipes VALUES (905,'water',CURDATE(),1,'type3','directions 5',0,'Person2');
INSERT INTO recipeIngredients VALUES (905,'water', 'any amount');

SELECT * FROM recipes LIMIT 10;
SELECT * FROM recipeIngredients LIMIT 10;

-- sort by newest (show everything)

SELECT * FROM recipes ORDER BY SubmitDate DESC LIMIT 10;

-- sort by oldest (show everything)

SELECT * FROM recipes ORDER BY SubmitDate ASC LIMIT 10;

-- sort by fastet preptime (show everything)

SELECT * FROM recipes ORDER BY PrepTime ASC LIMIT 10;

-- sort by longest preptime (show everything)

SELECT * FROM recipes ORDER BY PrepTime DESC LIMIT 10;

-- ----------------------------------------------------------------
-- recipeIngredients


-- get all ingredients (no quant) on db

SELECT Ingredient FROM recipeIngredients LIMIT 10;

-- search by ingredient (ex. sugar), show recipe name, author, date submitted, preptime , ingredient, quantity 

SELECT Name, Author, SubmitDate, PrepTime, Ingredient, Quantity -- exists sample 1
	FROM recipeIngredients, recipes 
		WHERE recipes.RecipeID = recipeIngredients.RecipeID AND Ingredient = 'sugar'
	LIMIT 10;

SELECT Name, Author, SubmitDate, PrepTime, Ingredient, Quantity -- exists sample 2
	FROM recipeIngredients, recipes 
		WHERE recipes.RecipeID = recipeIngredients.RecipeID AND Ingredient = 'eggs'
	LIMIT 10;

SELECT Name, Author, SubmitDate, PrepTime, Ingredient, Quantity -- does not exist
	FROM recipeIngredients, recipes 
		WHERE recipes.RecipeID = recipeIngredients.RecipeID AND Ingredient = 'guava'
	LIMIT 10;


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
SELECT COUNT(RecipeID) FROM reviews WHERE UserID = 'Person2' AND RecipeID = 4; -- user has made review for recipe 4
SELECT COUNT(RecipeID) FROM reviews WHERE UserID = 'Person2' AND RecipeID = 5; -- user has not made review for recipe 5

-- delete review
DELETE FROM reviews WHERE UserID = 'Person3' AND RecipeID = 1;   -- delete specific review
DELETE FROM reviews WHERE UserID = 'Person1';   -- delete all reviews by user

-- Make new review
INSERT INTO reviews VALUES ('Person3',2,5);

SELECT * FROM reviews WHERE UserID = 'Person3' LIMIT 10; 

-- Create Index to improve query performance for large datasets

CREATE Index ReviewIndex ON reviews(RecipeID); -- helps with following query

-- sort recipe by rating (show Name, Rating, PrepTime, Type, Author )
SELECT Name, avgRs.AverageRating, PrepTime, Type, Author 
	FROM recipes, (SELECT RecipeID, AVG(Rating) AS AverageRating FROM reviews GROUP BY RecipeID) AS avgRs
		WHERE recipes.RecipeID = avgRs.RecipeID ORDER BY avgRs.AverageRating DESC
	LIMIT 10;


-- ----------------------------------------------------------------
-- showing the end results
SELECT * FROM users LIMIT 10;
SELECT * FROM recipes LIMIT 10;
SELECT * FROM recipeIngredients LIMIT 10;
SELECT * FROM bookmarks LIMIT 10;
SELECT * FROM reviews LIMIT 10;