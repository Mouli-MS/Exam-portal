RGUKT EXAM GUARDIAN
“Online Test Preparation System developed for an Educational Institute of Rajiv Gandhi University of Knowledge Technologies (RGUKT).”

Technologies Used
Front-End (HTML5, CSS3, JS)
Backend (PHP - OOP)
Database (MySQLi)
Features of this Project
A. Users (Students) Can
Take Exams (Username & Password provided by Admin)
new users can register through Register Page
After login, Student will see the "Rules for Taking Exam"
After the exam is completed, you will get the results immediately and can also check the detail result view (You can see the answers you've selected to the questions and can also see the reason for that answer to be right.).
Rules are

Once you click on "Take Exam" button, the exam will begin and count down begins
Questions are selected randomly (If a student gets a question on no.1, another student might get the same question on different position or might not get the question at all)
You'll have to select an option and click on "Next" button to get another question.
You cannot go back to the previous question, Once 'Next' button is clicked.
If you close the window or click on "Quit" button, the session will be completed and you will be logged out. Then you won't have permission to log in again and take the exam. (You'll have to contact administrators to grant you permission to take the exam again).
B. Admins Can
Manage Admin Credentials
Manage Students (Create New, Update and Delete Existing Ones)
Manage Questions
Manage Faculties
Manage the Results of the Students.
Display the Wright and Wrong Answers with Detail Reasons.
How to Install and Run this project?
Pre-Requisites:
Download and Install XAMPP
Click Here to Download

Install any Text Editor (Sublime Text or Visual Studio Code or Atom or Brackets)
Installation
Download as as Zip or Clone this project
Extract and Move this project to Root Directory
Local Disc C: -> xampp -> htdocs -> 'this project'
Local Disk C is the location where xampp was installed

Open XAMPP Control Panel and Start 'Apache' and 'MySQL'

Extract and Import Database

Open 'phpmyadmin' in your browser
Create a Database ('quizapp')
Import the SQL file provided with this project ('quizapp')
Make Changes to settings
Go to 'admin' folder then'config' folder and Open 'constants.php' file. Then make changes on following constants

<?php 

//Create Constants to save Database Credentials
define('LOCALHOST', 'localhost');
define('USERNAME', 'root'); //Your Database username instead of 'root'
define('PASSWORD', ''); //Your Database Password instead of null/empty
define('DBNAME', 'quizapp'); //Your Database Name if it's not 'quizapp'

define('SITEURL', 'http://localhost/name_of_project_folder/'); //Update the home URL of the project if you have changed port number or it's live on server

?>
Now, Open the project in your browser. It should run perfectly.
CMS - Admin Panel
This is a very simple Content Management System (No advanced stuffs).

Instructions to use

Go to the link -> yourhomeurl/admin
e.g. http://localhost:81/name-of-project-folder/admin

Login with the Username and Password
[Username: admin, Password: admin]

Hola! You're logged in. Now you can manage categories, posts and users.
