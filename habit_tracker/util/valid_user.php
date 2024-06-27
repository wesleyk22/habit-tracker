<?php
    /* Code to make sure that a user is logged in and is a valid user, if not,
     * redirect them to the login page */
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . $app_path . 'user_login/user_login.php');
    } else {
        /* Variables for username and userID retrieved from the session array */
        $username = $_SESSION['username'];
        $userID = $_SESSION['user_id'];
    }
?>