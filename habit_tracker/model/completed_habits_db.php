<?php

/* object-oriented habitsDB class with public static methods for interacting 
 * with the habits table */

class CompletedHabitsDB {
    
    /* Function to get a users(userID) completed habits for a
     *  given month (monthID) and also gets the habitName via 
     * a JOIN clause (This function will return an array of CompletedHabit 
     * objects */
    public static function getUsersCompletedHabitsByMonth($userID, $monthID) {
        $db = Database::getDB();
        
        /* Using a join, select habitName from the habits table, then habitValue
         * and dayCompleted from the completedHabits table where habitID's
         * are the same (primary key in habits table, foreign key in completedHabits
         * table), and the desired userID and monthID match */
        $query = 'SELECT habitName, habitValue, dayCompleted
                  FROM habits
                  INNER JOIN completedHabits
                  ON completedHabits.habitID = habits.habitID
                  AND completedHabits.userID = :userID
                  AND completedHabits.monthID = :monthID';
        
        /* Get the rows and assign them to a $rows variable, then close 
         * connection to database */
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':monthID', $monthID);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        
        $completed_habits_array = [];
        /* With those rows, convert them into CompletedHabit objects and return
         * an array of these objects */
        //print_r($rows); // for debugging
        foreach ($rows as $row) {
            $completed_habit = new CompletedHabit();
            $completed_habit->setHabitName($row['habitName']);
            /* Use an if statement to avoid setting the habit value
             * to NULL, and instead an empty string */
            if ($row['habitValue'] != null) {
                $completed_habit->setHabitValue($row['habitValue']);
            } else {
                $completed_habit->setHabitValue('');
            }
            $completed_habit->setDayCompleted($row['dayCompleted']);
            
            // Add the CompletedHabit object to the array
            $completed_habits_array[] = $completed_habit;
        }
        
        // Return the array of Habit objects
        return $completed_habits_array;
    }

    /* Function to get all of the completed habits for a given day and month
     * for a specific user, using an inner join, it will select the name, 
     * tracking method, value, and id of each completed habit on this day. This
     * function will then return an array of CompletedHabit objects */
    public static function getCompletedHabitsForDay($dayCompleted, $monthID, $userID) {
        $db = Database::getDB();
        
        $query = 'SELECT habitName, trackedBy, habitValue, completedHabitID
                  FROM habits
                  INNER JOIN completedHabits
                  ON completedHabits.habitID = habits.habitID
                  AND completedHabits.dayCompleted = :dayCompleted
                  AND completedHabits.monthID = :monthID
                  AND completedHabits.userID = :userID';
        
        /* Get the rows and assign them to a $rows variable, then close 
         * connection to database */
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':monthID', $monthID);
        $statement->bindValue(':dayCompleted', $dayCompleted);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        
        
        $completed_habits_array = [];
        
        //print_r($rows); // for debugging
        /* With those rows, convert them into CompletedHabit objects and return
         * an array of these objects */
        foreach ($rows as $row) {
            $completed_habit = new CompletedHabit();
            $completed_habit->setCompletedHabitID($row['completedHabitID']);
            $completed_habit->setUserID($userID);
            $completed_habit->setMonthID($monthID);
            $completed_habit->setDayCompleted($dayCompleted);
            /* Use an if statement to avoid setting the habit value
             * to NULL, and instead an empty string */
            if ($row['habitValue'] != null) {
                $completed_habit->setHabitValue($row['habitValue']);
            } else {
                $completed_habit->setHabitValue('');
            }
            $completed_habit->setHabitName($row['habitName']);
            $completed_habit->setTrackingMethod($row['trackedBy']);
            
            // Add the CompletedHabit object to the array
            $completed_habits_array[] = $completed_habit;
        }
        
        // Return the array of Habit objects
        return $completed_habits_array;
        
    }

    /* Function to add a habit to the database, this does NOT set the value
     * of the habit, the value of this habit can be updated+changed via other
     * functions (by default the value will be NULL due to the SQL rule I set)\
     * this function takes a CompletedHabit object as a parameter */
    public static function addCompletedHabit($completed_habit) {
        $db = Database::getDB();
        
        /* Get the values from the CompletedHabit object and assign them to 
         * variables */
        $dayCompleted = $completed_habit->getDayCompleted();
        $userID = $completed_habit->getUserID();
        $habitID = $completed_habit->getHabitID();
        $monthID = $completed_habit->getMonthID();
        $habitValue = $completed_habit->getHabitValue(); // Default value
        
        /* Insert completed habit into the database */
        $query = 'INSERT INTO completedHabits
                    (dayCompleted, userID, habitID, monthID, habitValue)
                  VALUES
                    (:dayCompleted, :userID, :habitID, :monthID, :habitValue)';
        $statement = $db->prepare($query);
        $statement->bindValue(':dayCompleted', $dayCompleted);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':habitID', $habitID);
        $statement->bindValue(':monthID', $monthID);
        $statement->bindValue(':habitValue', $habitValue);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function userHasCompletedHabitByHabitID($dayCompleted, $userID, $habitID, $monthID) {
        $db = Database::getDB();
        
         $query = 'SELECT * FROM completedHabits
                  WHERE dayCompleted = :dayCompleted 
                  AND userID = :userID
                  AND habitID = :habitID
                  AND monthID = :monthID';
        $statement = $db->prepare($query);
        $statement->bindValue(':dayCompleted', $dayCompleted);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':habitID', $habitID);
        $statement->bindValue(':monthID', $monthID);
        $statement->execute();
        $found_habits_array = $statement->fetchAll();
        $statement->closeCursor();
        if (count($found_habits_array) >= 1) {
            return true; // User has the habit with that ID for this day/month
        } else {
            return false; // User doesnt have the habit with that ID for this day/month
        }
    }
    
    /* Function to update a completed habit's value based on the new value
     *  parameter and a given completed habit id: */
    public static function updateCompletedHabitValue($completed_habit_id, $new_value){
        $db = Database::getDB();
                
        $query = 'UPDATE completedHabits
                  SET habitValue = :new_value
                  WHERE completedHabitID = :completed_habit_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':completed_habit_id', $completed_habit_id);
        $statement->bindValue(':new_value', $new_value);
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function deleteCompletedHabits($userID, $habitID){
        $db = Database::getDB();
                
        $query = 'DELETE FROM completedHabits
                  WHERE userID = :userID AND habitID = :habitID';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':habitID', $habitID);
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function userHasCompletedHabit($userID, $completed_habit_id) {
        $db = Database::getDB();
        
         $query = 'SELECT * FROM completedHabits
                  WHERE userID = :userID
                  AND completedHabitID = :completedHabitID';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':completedHabitID', $completed_habit_id);
        $statement->execute();
        $found_habits_array = $statement->fetchAll();
        $statement->closeCursor();
        if (count($found_habits_array) >= 1) {
            return true; // User has the completed habit with that completedHabitID
        } else {
            return false;
        }
    }
    
    /* Function to remove a completed habit with associated with a given 
     * userID and completedHabitID */
    public static function removeCompletedHabit($userID, $completed_habit_id){
         $db = Database::getDB();
                
        $query = 'DELETE FROM completedHabits
                  WHERE userID = :userID 
                  AND completedHabitID = :completedHabitID';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':completedHabitID', $completed_habit_id);
        $statement->execute();
        $statement->closeCursor();
    }

}

?>
