<?php

/* CompletedHabit class that will extend the Habit class, this will have
 * member variables dayCompleted, habitValue, and monthID on top of the
 * inherited member variables from the superclass */

class CompletedHabit extends Habit {
    
    /* Constructor that uses property promotion to
     * instantiate the member variables with default variables along 
     * with the object's instantiation itself */
    public function __construct(
            // Member variables of superclass
            int $habit_id = 0,
            string $habit_name = '',
            string $tracking_method = '',
            int $user_id = 0,
            // Member variables of this class
            private int $completed_habit_id = 0,
            private int $day_completed = 0,
            private string $habit_value = '',
            private int $month_id = 0,) {
        /* Call the superclass's constructor to finish initialization */
        parent::__construct($habit_id, $habit_name, $tracking_method, $user_id);
    }

    // Getters
    public function getDayCompleted() {
        return $this->day_completed;
    }

    public function getHabitValue() {
        return $this->habit_value;
    }

    public function getMonthID() {
        return $this->month_id;
    }
    
    public function getCompletedHabitID() {
        return $this->completed_habit_id;
    }

    
    // Setters
    public function setDayCompleted(int $value) {
        $this->day_completed = $value;
    }

    public function setHabitValue(string $value) {
        $this->habit_value = $value;
    }

    public function setMonthID(int $value) {
        $this->month_id = $value;
    }
    
    public function setCompletedHabitID(int $value) {
        $this->completed_habit_id = $value;
    }


    
}

?>