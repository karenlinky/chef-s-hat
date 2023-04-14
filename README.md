# CS348Project

# Loading Sample Data into Database:

1) Start up MySQL by logging in to your user:
> mysql -u 'UserName' -p

2) Set up the global variables:
mysql> SET GLOBAL local_infile=1;

3) Quit the current MySQL server:
mysql> quit

4) Restart the server with the local-infile variable:
> mysql --local-infile=1 -u 'UserName' -p

5) If your database doesn't exist, create a database called Recipes:
mysql> CREATE DATABASE Recipes;

6) Enter your database:
mysql> USE Recipes;

7) Add a user for the database:
mysql> CREATE USER 'UserJKN'@'localhost' identified by 'PasswordJKN';
mysql> GRANT ALL ON Recipes.* TO 'UserJKN'@'localhost';
mysql> ALTER USER 'UserJKN'@'localhost' IDENTIFIED WITH mysql_native_password BY 'PasswordJKN';

8) Create tables if they don't exist:
mysql> \. createtables.sql

9) Populate tables if they aren't populated:
mysql> \. populatetables.sql
** make sure the required .txt files containing the data are in the same directory as populatetables.sql **

10) Start PHP (In a new terminal):
php -S 127.0.0.1:8000

11) Open php file in browser http://127.0.0.1:8000/PATHTOPHP/Register.php


The database is working in our code. This is tested by registering a new user through Register.php. We can successfully create a user and the change is reflected in the database through doing SELECT * FROM Users;.







