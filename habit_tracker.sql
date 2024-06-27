DROP DATABASE IF EXISTS habit_tracker;
CREATE DATABASE habit_tracker;
USE habit_tracker;

-- Users table
CREATE TABLE users (
  userID            INT           NOT NULL      AUTO_INCREMENT,
  password          VARCHAR(255)   NOT NULL,
  username          VARCHAR(60)   NOT NULL,
  dateCreated       DATETIME      DEFAULT NULL,
  PRIMARY KEY (userID)
);

-- Habits table
CREATE TABLE habits (
  habitID           INT           NOT NULL      AUTO_INCREMENT,
  habitName         VARCHAR(60)   NOT NULL,
  trackedBy         VARCHAR(60)   NOT NULL,
  userID            INT           NOT NULL,
  PRIMARY KEY (habitID)
);

-- Completed habits table
CREATE TABLE completedHabits (
  completedHabitID  INT           NOT NULL     AUTO_INCREMENT,
  dayCompleted      INT           NOT NULL,
  habitValue        VARCHAR(60)   DEFAULT NULL,
  userID            INT           NOT NULL,
  habitID           INT           NOT NULL,
  monthID           INT           NOT NULL,
  PRIMARY KEY (completedHabitID)
);

-- Months table that 12 month values will be stored in
CREATE TABLE months (
  monthID           INT           NOT NULL   AUTO_INCREMENT,
  monthName         VARCHAR(60)   NOT NULL,
  numDays           INT           NOT NULL,
  PRIMARY KEY (monthID)
);

-- Users table default data
INSERT INTO users (password, username) VALUES
("$2y$10$rodxRfrHHphURFL52RYY7urIQa6O1EJl8ynOsoNSndcVUxbKmhssG", "ExampleUser1"),
("$2y$10$Jv4mkhCvAHP9Hcx4HfllrOjqwnba/OU8RrCJ9Vp04HUTR9PLftTxm", "ExampleUser2"),
("$2y$10$DHxa9EBsRkLsMTUd6WaujeuJfDvHVE.MtuaSsP4x7YAxuho5WSlES", "ExampleUser3");

-- Habits table default data
INSERT INTO habits (habitName, trackedBy, userID) VALUES
("Studied", "Time", -1),
("Exercised", "DidOrDidnt", -1),
("Calories", "Number", -1);

-- Months table default data
INSERT INTO months (monthName, numDays) VALUES
("January", 31),
("February", 28),
("March", 31),
("April", 30),
("May", 31),
("June", 30),
("July", 31),
("August", 31),
("September", 30),
("October", 31),
("November", 30),
("December", 31);

-- Create a user for habittracker_user
CREATE USER IF NOT EXISTS habittracker_user@localhost
IDENTIFIED BY 'pa55word';

-- grant privileges to the habittracker_user
GRANT SELECT, INSERT, UPDATE, DELETE
ON habit_tracker.*
TO habittracker_user@localhost;

