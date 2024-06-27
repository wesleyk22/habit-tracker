<?php

/* object-oriented Database class with private static member variables and methods.
 * Making this into a class with static member variables and methods removes
 * the problem of users constantly re-connecting to the database each time 
 * they access the page. Instead, they will repeatedly be retrieving
 * a reference to a PDO object using the getDB() method */

class Database {   
    private static $dsn = 'mysql:host=localhost;dbname=habit_tracker';
    private static $username = 'habittracker_user';
    private static $password = 'pa55word';
    private static $db;
    
    // Don't allow objects of this class to be constructed
    private function __construct() {}
    
    public static function getDB(){
        // Check if the member variable $db isn't already assigned
        if (!isset(self::$db)) {
            /* If it isn't, try assigning it to a PDO object that can be
             * referenced*/
            try {
                self::$db = new PDO(self::$dsn, self::$username, self::$password);
            /* If creating and assigning the PDO fails, include the database
             * error page and display the error */
            } catch (Exception $e) {
                $error_message = $e->getMessage();
                include('../errors/database_error.php');
                exit(); // terminate this script and exit this code
            }
        }
        /* If we are here, then we can safely return the $db variable that
        includes a reference to the PDO object */
        return self::$db;
    }
}
?>