<?php
/* This main.php in the utility folder will store things like commonly
 * re-used directories/functions/required database files, to avoid repitition,
 * it is also coded into this one file. */

/* Get document root, htdocs is the root document of the Apache server */
$doc_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');

/* Get application path (This code assumes the application  is 2 directories 
 * down from the root) */
$uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
$directories = explode('/', $uri);
$app_path = '/' . $directories[1] . '/' . $directories[2] . '/';

/* Constants */
const DEFAULT_TIME_VALUE = "00:00:00";
const DEFAULT_NUMBER_VALUE = "0";
const DEFAULT_DIDORDIDNT_VALUE = "Didnt";

/* Set include path, this tells PHP where to look for the files specified in
 * include(), require(), require_once() functions */
set_include_path($doc_root . $app_path);

/* Common code that almost all of the index.php controller files in this
 * application will use: */
require_once('model/database.php');
require_once('util/secure_conn.php');

/* Re-usable redirect function that is more intuitive than just using the header
 * function over and over */
function redirect($url) {
    session_write_close(); // End the current session
    header("Location: " . $url); // Redirect to that url using the built in header function
    exit(); // Terminate execution of this script 
}

/* Start a session if there isn't one started already, this session
 * will store user data, and a variable that is set if the user is a valid user
 * that is logged in or not, if that variable isn't set, they will be redirected
 * to the login page */
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}


 

