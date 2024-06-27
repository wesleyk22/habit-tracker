# Habit Tracker project

This is a full stack web application that allows users to create accounts and track their habits.

## Description

This project is a habit tracker application that is made with HTML, CSS, A little bit of javascript, PHP, and MySQL. It allows users to create accounts and track their habits, make
different types of habits, and set values to those habits.

## What I personally learned from building this project

This project taught me a lot about web development fundamentals. I learned how to design a SQL
database for an application, understanding primary and foreign keys and basic-level database design. I learned how to implemented a MVC pattern in a web application with PHP. I learned a lot of PHP syntax and how to use it to communicate with a database. I also learned how to use a bit
of javascript on the front end to implement a dark/light mode feature. I learned a lot of web-development/PHP specific concepts, such as Post-redirect-get pattern, working with forms, data validation, password hashing, secure connection with HTTPS, OOP in PHP, and more. Overall I really feel like building this project helped
me get a good fundamental understanding into full stack web development.

## How to run the program

To run this program, I set up XAMMP and ran it locally on my computer with that. You set htdocs to
be the root folder of Apache and put the project in there. All of the files should be put into a folder called "integrated-programming-project" (which is just what this project started off as, a community college project for a web application class) for it to work aswell. You start XAMMP and make sure both Apache and
MySQL are running. Then you create the database by going into phpmyadmin, and running the habit_tracker.sql script in the "import" tab, creating / or resetting the database if it was already there. By default
there are three users, ExampleUser1 through ExampleUser3 all with passwords abc123. Or you can create a new
account and start using it that way. 

It should also be noted that I configured XAMMP and Apache to the specifications in the murach book that I credit down below, and that may need to be done to get this project to work correctly.

## Acknowledgments/Credits

All of my PHP and mySQL knowledge comes from reading and following along with the exercises in this book: https://www.murach.com/shop/murach-s-php-and-mysql-4th-edition-detail it was the book for my Web Application Development college class and I really did enjoy the book, it's a lot of reading, but also a lot of exercises with hands-on work and an example prototype project at the end that I can reference to get an idea of how to organize and build my project. 

There are also two icons that I used in the project, a "delete" button and a "reset" button that were
obtained from here:
https://www.flaticon.com/free-icon/delete_3405244?term=delete&page=1&position=4&origin=tag&related_id=3405244
https://www.flaticon.com/free-icon/undo_7794645?term=reset&page=1&position=5&origin=search&related_id=7794645

