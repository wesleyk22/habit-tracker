<?php

/* Habit class with getters and setters for member variables of habitID,
 * habitName, tracking_method AKA trackedBy in SQL table, and userID
 * for the user that created this habit */

class Habit {

    /* Constructor that uses property promotion to
     * instantiate the member variables with default variables along 
     * with the object's instantiation itself */
    public function __construct(
        private int $habit_id = 0,
        private string $habit_name = '',
        private string $tracking_method = '',
        private int $user_id = 0,
    ) { }

    // Getters
    public function getHabitID() {
        return $this->habit_id;
    }

    public function getHabitName() {
        return $this->habit_name;
    }

    public function getTrackingMethod() {
        return $this->tracking_method;
    }

    public function getUserID() {
        return $this->user_id;
    }

    // Setters
    public function setHabitID(int $value) {
        $this->habit_id = $value;
    }

    public function setHabitName(string $value) {
        $this->habit_name = $value;
    }

    public function setTrackingMethod(string $value) {
        $this->tracking_method = $value;
    }

    public function setUserID(int $value) {
        $this->user_id = $value;
    }
}

?>