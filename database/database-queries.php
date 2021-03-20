<!-- Creates the employees SQL table -->
CREATE TABLE employees
(
    employeeID INT NOT NULL AUTO_INCREMENT,
    firstName VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    userPassword VARCHAR(30) NOT NULL,
    employeeEmail VARCHAR(50) NULL,
    manager BOOLEAN NOT NULL,
    PRIMARY KEY(employeeID)
);

<!-- Creates the incidents SQL table -->
CREATE TABLE incidents
(
    incidentID INT NOT NULL AUTO_INCREMENT,
    employeeID INT NOT NULL,
    position INT(1) NOT NULL,
    dateHelped DATE NOT NULL,
    timeHelped TIME(0) NOT NULL,
    location VARCHAR(20) NOT NULL,
    locationOther VARCHAR(20),
    question VARCHAR(30) NOT NULL,
    questionOther VARCHAR(30),
    contactMethod VARCHAR(20) NOT NULL,
    filedIncidentReport BOOLEAN NOT NULL,
    incidentReportNumber INT(5),
    comments VARCHAR(300),
    submissionTime DATETIME NOT NULL,
    PRIMARY KEY(incidentID),
    FOREIGN KEY(employeeID) REFERENCES employees(employeeID)
);

<!-- Creates the dayHistory SQL table -->
CREATE TABLE dayHistory
(
    dayDate DATE NOT NULL,
    day VARCHAR(10) NOT NULL,
    totalIncidents INT(3) NOT NULL,
    totalZoomIncidents INT(3) NOT NULL,
    totalPhoneIncidents INT(3) NOT NULL,
    totalSHD1Incidents INT(3) NOT NULL,
    totalSHD2Incidents INT(3) NOT NULL,
    totalIncidentsReportsFiled INT(3) NOT NULL,
    PRIMARY KEY(dayDate)
);

<!-- Creates manager account -->
INSERT INTO employees (firstName, lastName, username, userPassword, employeeEmail, manager)
VALUES ('Kim', 'Olsen', 'admin', '@dm!n', 'kOlsen@greenriver.edu', 1);

<!-- Creates employee account -->
INSERT INTO employees (firstName, lastName, username, userPassword, employeeEmail, manager)
VALUES ('Dailee', 'Howard', 'daileehoward', 'greenriver!', 'Dhoward@greenriver.edu', 0);