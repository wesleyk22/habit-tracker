<?php

/* object-oriented userDB class with public static methods for interacting 
 * with the users table */

class UsersDB {
    
    public static function isValidUserLogin($username, $password){
        $db = Database::getDB();
        
        $query = 'SELECT password, userID
                  FROM users
                  WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if ($row == NULL ) { // Could not find username
            return null;
        } else { // Otherwise, we did find the username
            $hashed_password = $row['password'];
            /* Check if the password is correct by using the password_verify
             * function that will return true if the password matches the
             * specified hash */
            if (password_verify($password, $hashed_password) == true) { 
                return $row;
            } else {
                return null;
            }
        }
    }
    
    public static function createAccount($username, $password){
        $db = Database::getDB();
        /* Create a hash of the password using the password_hash function,
         * this is a built-in PHP function that uses strong salt and a strong
         * a strong one-way encryption algorithim */
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = 'INSERT INTO users
                  (password, username) 
                  VALUES
                  (:password, :username)';
        $statement = $db->prepare($query);
        $statement->bindValue(':password', $hashed_password);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function usernameExists($username){
        $db = Database::getDB();
        
        $query = 'SELECT * FROM users
                  WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();
        if ($user != NULL) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function getUserID($username){
        $db = Database::getDB();
        
        $query = 'SELECT username, userID
                  FROM users
                  WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        //print_r($row); // for testing
        if ($row != null) {
            return $row['userID']; 
        } else {
            return null;
        }
        
    }
}    
?>
