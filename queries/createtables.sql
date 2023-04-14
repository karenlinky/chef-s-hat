CREATE TABLE users
(
    UserID VARCHAR(20) NOT NULL PRIMARY KEY,
    Password VARCHAR(70) NOT NULL
);

CREATE TABLE recipes
(
    RecipeID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(30),
    SubmitDate DATE,
    PrepTime DECIMAL(9, 0),
    Type VARCHAR(30),
    Directions VARCHAR(1000),
    FlagInactive BOOLEAN,
    Author VARCHAR(20) NOT NULL,
    FOREIGN KEY(Author) REFERENCES users(UserID)
);

CREATE TABLE recipeIngredients
(
    RecipeID INT,
    Ingredient VARCHAR(30) NOT NULL,
    Quantity VARCHAR(40),
    FOREIGN KEY(RecipeID) REFERENCES recipes(RecipeID),
    PRIMARY KEY(RecipeID, Ingredient)
);

CREATE TABLE bookmarks
(
    UserID  VARCHAR(20) NOT NULL,
    RecipeID INT NOT NULL,
    BookmarkDate DATE,
    PRIMARY KEY(UserID, RecipeID),
    FOREIGN KEY(UserID) REFERENCES users(UserID),
    FOREIGN KEY(RecipeID) REFERENCES recipes(RecipeID)
);

CREATE TABLE reviews
(
    UserID  VARCHAR(20) NOT NULL,
    RecipeID INT NOT NULL,
    Rating DECIMAL(9, 0),
    PRIMARY KEY(UserID, RecipeID),
    FOREIGN KEY(UserID) REFERENCES users(UserID),
    FOREIGN KEY(RecipeID) REFERENCES recipes(RecipeID)
);
