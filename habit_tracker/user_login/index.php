<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Index / "Controller" for user_login 
 */

// Main utility file
require_once('../util/main.php');

// Database files
require_once('model/habit.php');
require_once('model/completedhabit.php');
require_once('model/users_db.php');
require_once('model/habits_db.php');
require_once('model/completed_habits_db.php');
require_once('model/months_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'user_login'; // Default page
    }
}


     
switch ($action) {
    case 'under_construction': 
        include('../under_construction.php');
        break;
    case 'create_account':
        include('./account_create.php');
        break; 
    case 'login_attempt': 
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
                
        if (UsersDB::isValidUserLogin($username, $password) == false) {
            $invalid_user_message = "Username/password not found. Please try again or click 'Create Account' to create a new account";
            include('./user_login.php');
        } else { // Otherwise, we did find the user/password in the database.
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = UsersDB::getUserID($username);
            include('../index.php');
        }
        break;
    case 'account_create_attempt':
        // Check if the username exists and if it does warn user and let them retry:
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        
        /* Data validation */
        if (empty($username) || empty($password)){
            $invalid_create_message = "One or more of the fields does not contain data. Please try again";
            include('./account_create.php');
            break;
        }
        
        $passwordContainsLetter = preg_match('/[a-zA-Z]/', $password);
        $passwordContainsDigit = preg_match('/\d/', $password);
        
        if ( ($passwordContainsLetter && $passwordContainsDigit) == false){
            $invalid_create_message = "Please make sure your password has both letters and numbers.";
            include('./account_create.php');
            break;
        }
        
        if (UsersDB::usernameExists($username)){
            $invalid_create_message = "That username already exists. Please try again";
            include('./account_create.php');
        } else {
            // Create the account
            UsersDB::createAccount($username, $password);
            $account_creation_success_message = "Account with username of " . $username . " Successfully created! Login with that account below:";
            include('./user_login.php');
        }
        break;
    case 'user_login':
        include('./user_login.php');
        break;
    case 'logout':
        /* Unset session variables */
        session_unset();
        /* Using the defined $app_path variable from util/main, redirect the
         * user to the default page of this website after ending the session */
        redirect($app_path);
        break;
}

?>

