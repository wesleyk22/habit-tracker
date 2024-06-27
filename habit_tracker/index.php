<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Home page
 */

// Main utility file
require_once('util/main.php');

// Check that user is a valid user
require_once('util/valid_user.php');

// for testing
// foreach ($_SESSION as $key => $value) {
//    echo "$key: $value<br>";
// }
// echo "sessionID:" . session_id();

// Display the home page
include('home_view.php');

