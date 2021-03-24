# Patron Tracker
Built a web application for Student Help Desk Employees of Green River College to keep track of the statistics of the the patrons that they help.

## Final Project Requirements:
- Separates all database/business logic using the MVC pattern.
   - Database logic found in model/database.php, business logic found in views/ 
   
- Routes all URLs and leverages a templating language using the Fat-Free framework.
    - Routes are created in index.php that utilizes the functions created in the Controller class found in controllers/controller.php

- Has a clearly defined database layer using PDO and prepared statements. You should have at least two related tables.
    - PDO and prepared statements incorporated in Database class found in model/database.php. SQL statements, including the create table statements, found in comments at top of Database class. 
- Data can be viewed and added.
    - Data added to incident and dayHistory table in SQL database when an employee submits a form
    - Currently two employees can login to the site. Our "manager" username and password are: 
        - user: admin
        - pass: @dm!n 
- Has a history of commits from both team members to a Git repository. Commits are clearly commented.
    - 95 commits total currently from both team members
- Uses OOP, and defines multiple classes, including at least one inheritance relationship.
    - Database, Validate, and DataLayer classes found in model/
    - Employee, Manager, Incident, and DayHistory classes found in classes/. Employee class inherits from Manager class.
- Contains full Docblocks for all PHP files and follows PEAR standards.
    - Included Docblocks and followed PEAR standards in all PHP files
- Has full validation on the client side through JavaScript and server side through PHP.
    - Server side validation through PHP found in model/validate.php, doesn't have client side validation with JS
- All code is clean, clear, and well-commented. DRY (Don't Repeat Yourself) is practiced.
    - Included comments and tried to reduce redundancy in code for all files
- Your submission shows adequate effort for a final project in a full-stack web development course.
    - Incoroprated topics we learned throughout the quarter (Fat-Free Framework (f3), the MVC pattern, OOP, and PDO)
