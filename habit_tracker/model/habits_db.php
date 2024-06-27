<?php

/* object-oriented habitsDB class with public static methods for interacting 
 * with the habits table */

class HabitsDB {
    
    /* Method to get and return the global habits, this method will
     * return an array of Habit objects */
    public static function getGlobalHabits() {
        $db = Database::getDB();
        
        /* Select from habits where userID is equal to -1, AKA global habits */
        $query = 'SELECT * FROM habits
                  WHERE userID = -1';
        $statement = $db->prepare($query);
        $statement->execute();
        
        /* Get the rows, and then close the connection to database */
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        
        $habits = [];
        /* With these rows, convert them into Habit objects and return
         * that array of Habit objects */
        foreach ($rows as $row) {
            $habit = new Habit();
            $habit->setHabitID($row['habitID']);
            $habit->setHabitName($row['habitName']);
            $habit->setTrackingMethod($row['trackedBy']);
            $habit->setUserID($row['userID']);
            
            // Add the Habit object to the array
            $habits[] = $habit; 
        }
        
        // Return the array of Habit objects
        return $habits;
    }

    /* Method to add a habit to the database, it accepts a Habit object
     * as a parameter */
    public static function submitHabit($habit) {
        $db = Database::getDB();
        
        /* Get the values from the Habit object and assign them to 
         * variables */
        $userID = $habit->getUserID();
        $habit_name = $habit->getHabitName();
        $tracking_method = $habit->getTrackingMethod();
        
        /* Insert habit into the database */
        $query = 'INSERT INTO habits
                    (habitName, trackedBy, userID)
                  VALUES
                    (:habit_name, :tracking_method, :userID)';
        $statement = $db->prepare($query);
        $statement->bindValue(':habit_name', $habit_name);
        $statement->bindValue(':tracking_method', $tracking_method);
        $statement->bindValue(':userID', $userID);
        $statement->execute();
        $statement->closeCursor();
    }

    /* Method to check if a given user has a certain habit, takes
     * a userID and a habit object as parameters */
    public static function userHasHabitByName($userID, $habit_name) {
          $db = Database::getDB();
                
        $query = 'SELECT * FROM habits
                  WHERE userID = :userID AND habitName = :habitName';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':habitName', $habit_name);
        $statement->execute();
        $found_habits_array = $statement->fetchAll();
        $statement->closeCursor();
        if (count($found_habits_array) >= 1) {
            return true; // User has the habit with that ID
        } else {
            return false; // User doesnt have the habit with that ID
        }
    }

    /* Method for checking if a user has a habit for a given userID
     * and habitID */
    public static function userHasHabitByID($userID, $habitID) {
        $db = Database::getDB();     
                
        $query = 'SELECT * FROM habits
                  WHERE userID = :userID AND habitID = :habitID';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':habitID', $habitID);
        $statement->execute();
        $found_habits_array = $statement->fetchAll();
        $statement->closeCursor();
        //echo $userID; for debugging
        //echo $habitID; for debugging
        //print_r($found_habits_array); for debugging
        if (count($found_habits_array) >= 1) {
            return true; // User has the habit with that ID
        } else {
            return false; // User doesnt have the habit with that ID
        }
    }

    /* Method to return an array of Habit objects associated with a given
     *  userID */
    public static function getUsersHabits($userID) {
        $db = Database::getDB();
        
        /* Select from habits where userID is equal to -1, AKA global habits */
        $query = 'SELECT * FROM habits
                  WHERE userID = :userID';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->execute();
        
        /* Get the rows, and then close the connection to database */
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        
        $habits = [];
        /* With these rows, convert them into Habit objects and return
         * that array of Habit objects */
        foreach ($rows as $row) {
            $habit = new Habit();
            $habit->setHabitID($row['habitID']);
            $habit->setHabitName($row['habitName']);
            $habit->setTrackingMethod($row['trackedBy']);
            $habit->setUserID($row['userID']);
            
            // Add the Habit object to the array
            $habits[] = $habit; 
        }
        
        // Return the array of Habit objects
        return $habits;
    }

    /* Method to delete a habit from the table associated with a given userID
     * and habit Object */
    public static function deleteHabit($userID, $habitID) {
        $db = Database::getDB();
        
        $query = 'DELETE FROM habits
                  WHERE userID = :userID AND habitID = :habitID';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':habitID', $habitID);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function getTrackingMethod($habitID) {
        $db = Database::getDB();

        /* Select from habits where userID is equal to -1, AKA global habits */
        $query = 'SELECT * FROM habits
                  WHERE habitID = :habitID';
        $statement = $db->prepare($query);
        $statement->bindValue(':habitID', $habitID);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        
        return $row['trackedBy'];
    }

}


