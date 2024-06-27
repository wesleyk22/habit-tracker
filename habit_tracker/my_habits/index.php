<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Index / "Controller" for my_habits
 */


// Main utility file
require_once('../util/main.php');

// Check that user is a valid user
require_once('util/valid_user.php');

// Database files
require_once('model/habit.php');
require_once('model/completedhabit.php');
require_once('model/users_db.php');
require_once('model/habits_db.php');
require_once('model/completed_habits_db.php');
require_once('model/months_db.php');

// Helper functions for this section of website
require_once('helpers.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'view_completed_habits'; // Default page
    }
}

/* Set session variables to variables that can be used in the code */
if (isset($_SESSION['selected_day'])) {$day_to_customize = $_SESSION['selected_day'];}
if (isset($_SESSION['selected_month_id'])) {$monthID = $_SESSION['selected_month_id'];}
if (isset($_SESSION['selected_month_name'])) {$monthName = $_SESSION['selected_month_name'];}

/* If the message variable is not set, set it to an empty string */
if (!isset($_SESSION['message'])) {$_SESSION['message'] = '';}
       
switch ($action) {
    case 'under_construction': 
        include('../under_construction.php');
        break;
    case 'view_completed_habits':
        /* Deconstruct and assign variables */
        [$currentMonthID, $currentMonthName, $currentDay, $daysInMonth, 
        $nameOfStartingDay, $grayedDays, $calendarDays] = getCurrentMonthStats();

        $_SESSION['selected_month_id'] = $currentMonthID;
        $_SESSION['selected_month_name'] = $currentMonthName;

        // Clear the message variable
        $_SESSION['message'] = '';

        //echo "month name:" . $currentMonthName;
        $users_completed_habits = CompletedHabitsDB::getUsersCompletedHabitsByMonth($userID, $currentMonthID);
        include('./completed_habits_list.php');
        break; 
    case 'customize_day':
        /* Change these to GET */
        $day_to_customize = filter_input(INPUT_GET, 'day_to_customize');
        $_SESSION['selected_day'] = $day_to_customize;
        $monthID = filter_input(INPUT_GET, 'month_id');
        $customize_day_message = '';
        
        $day_to_customize = $_SESSION['selected_day'];
        $monthID = $_SESSION['selected_month_id'];
        $userID = $_SESSION['user_id'];
        $customize_day_message = $_SESSION['message'];
        
        // Get completed habits for this day
        $completed_habits_for_this_day = CompletedHabitsDB::getCompletedHabitsForDay($day_to_customize, $monthID, $userID);
    
        // Get the global habits (habits that any user can use)
        $global_habits = HabitsDB::getGlobalHabits();
        
        // Get users habits
        $users_habits = HabitsDB::getUsersHabits($userID);
    
        $month_name = MonthsDB::getMonthNameByID($monthID);
        include('./customize_day.php');
        
        break; 
    case 'add_completed_habit':
        $habitID = (int)filter_input(INPUT_POST, 'habit_id');
        
        /* Data validation: make sure this habit is not already in this day
           before adding it: */
        if (CompletedHabitsDB::userHasCompletedHabitByHabitID($day_to_customize, $userID, $habitID, $monthID)){
            $_SESSION['message'] = "You already have this habit added to this day, if you want to change the value, change it below:";
        } else {
            // Instantiate a CompletedHabit object and send that as a parameter
            $completed_habit = new CompletedHabit();
            $completed_habit->setDayCompleted($day_to_customize);
            $completed_habit->setMonthID($monthID);
            $completed_habit->setHabitID($habitID);
            $completed_habit->setUserID($userID);

            // Set a default value based on the tracking method
            $tracking_method = HabitsDB::getTrackingMethod($habitID);
            if ($tracking_method == "Time") {
                $completed_habit->setHabitValue(DEFAULT_TIME_VALUE);
            } else if ($tracking_method == "DidOrDidnt") {
                $completed_habit->setHabitValue(DEFAULT_DIDORDIDNT_VALUE);
            } else if ($tracking_method == "Number") {
                $completed_habit->setHabitValue(DEFAULT_NUMBER_VALUE);
            }

            CompletedHabitsDB::AddCompletedHabit($completed_habit);
            $_SESSION['message'] = "Completed habit has been added to this day";
        }
        
        /* Redirect to customize day with GET */
         redirect($app_path . 'my_habits/index.php?action=customize_day&month_id=' . $monthID . '&day_to_customize=' . $day_to_customize . '&month_name=' . $monthName);
        break; 
    case 'update_habit_value':
        /* POST Variables that may or may not be set depending 
        on what kind of habit is being updated */
        if (isset($_POST['new_value'])) {
            $new_value = filter_input(INPUT_POST, 'new_value');
        }
        
        /* POST Variables that will always be there no matter 
        what kind of habit is being updated */
        $habit_value = filter_input(INPUT_POST, 'habit_value');
        $tracking_method = filter_input(INPUT_POST, 'tracking_method');
        $completed_habit_id = filter_input(INPUT_POST, 'completed_habit_id');
        
        // Assume the data is valid to start off
        $data_is_valid = true;
        
        /* Data validation for the DidOrDidnt tracking method */
        if ($tracking_method == "DidOrDidnt") {
            if ($new_value != "Did" && $new_value != "Didnt") {
                $customize_day_message = "There was invalid data sent for the value and tracking method DidOrDidnt, please try again.";
                $data_is_valid = false;
            }
        }
        
        /* Data validation for the Number tracking method */
        if ($tracking_method == "Number") {
                // Check if the "add" and "subtract" POST values exist and are not null using isset()
                if ( (isset($_POST['add'])) && (isset($_POST['subtract'])) ) { 
                    $value_to_add = filter_input(INPUT_POST, 'add');
                    $value_to_subtract = filter_input(INPUT_POST, 'subtract');
                    $pattern = "/^\d+$/";
                    // /* Regular expression for checking that there are 
                    //  * atleast one or more digits in the string */
                    if ( (preg_match($pattern, $value_to_add) == 1) && (preg_match($pattern, $value_to_subtract) == 1) ) {
                        $new_value = subtract_and_add_number($habit_value, $value_to_add, $value_to_subtract);
                    } else {
                        $_SESSION['message'] = "Invalid data, for the Number tracking method, enter one or more digits 0-9.";
                        $data_is_valid = false;
                    }
                }
        }
        
        /* Data validation for the Time tracking method */
        if ($tracking_method == "Time") {
            // Check if the "add" and "subtract" POST values exist and are not null using isset()
            if ( (isset($_POST['add_time'])) && (isset($_POST['subtract_time'])) ) { 
                $time_to_add = filter_input(INPUT_POST, 'add_time');
                $time_to_subtract = filter_input(INPUT_POST, 'subtract_time');

                $pattern = "/^\d{1,2}:\d{1,2}:\d{1,2}$/";
                if ( (preg_match($pattern, $time_to_add) == 1) && (preg_match($pattern, $time_to_subtract) == 1) ) {
                    $new_value = subtract_and_add_time($habit_value, $time_to_add, $time_to_subtract);
                } else {
                    $_SESSION['message'] = "Invalid data, for the Time tracking method, Enter exactly one colon with 0-9 digits on either side";
                    $data_is_valid = false;
                }

            }

            /* Regular expression for checking that there are 
             * atleast one or more digits in the string */
            // if (preg_match("/^\d{1,2}:\d{1,2}:\d{1,2}$/", $new_value) != 1) {
            //     $_SESSION['message'] = "Invalid data, for the Time tracking method, Enter exactly one colon with 0-9 digits on either side";
            //     $data_is_valid = false;
            // } else {
            //     $new_value = format_into_leading_zeroes($new_value);
            // }
        }
        
        if ($data_is_valid == true){
            CompletedHabitsDB::updateCompletedHabitValue($completed_habit_id, $new_value);
            $_SESSION['message'] = "Habit value has been updated.";
        }
        
        /* Redirect to customize day with GET */
        redirect($app_path . 'my_habits/index.php?action=customize_day&month_id=' . $monthID . '&day_to_customize=' . $day_to_customize . '&month_name=' . $monthName);
        break; 
    case 'remove_completed_habit':
        $completed_habit_id = filter_input(INPUT_POST, 'completed_habit_id');
        
        /* Data validation: make sure this user has this completed habit before trying to 
         * remove it */
        if (CompletedHabitsDB::userHasCompletedHabit($userID, $completed_habit_id)){
            // Remove the habit
            CompletedHabitsDB::removeCompletedHabit($userID, $completed_habit_id);
            $_SESSION['message'] = "Completed habit successfully removed.";
        }
        
        /* Redirect to customize day with GET */
        redirect($app_path . 'my_habits/index.php?action=customize_day&month_id=' . $monthID . '&day_to_customize=' . $day_to_customize . '&month_name=' . $monthName);
        break;
    case 'reset_habit_value':
        $habit_value = filter_input(INPUT_POST, 'habit_value');
        $tracking_method = filter_input(INPUT_POST, 'tracking_method');
        $completed_habit_id = filter_input(INPUT_POST, 'completed_habit_id');

        $data_is_valid = true;

        // Set a default value based on the tracking method
        $new_value = "";
        if ($tracking_method == "Time") {
            $new_value = (DEFAULT_TIME_VALUE);
        } else if ($tracking_method == "DidOrDidnt") {
            $new_value = (DEFAULT_DIDORDIDNT_VALUE);
        } else if ($tracking_method == "Number") {
            $new_value = (DEFAULT_NUMBER_VALUE);
        }

        if ($data_is_valid == true){
            CompletedHabitsDB::updateCompletedHabitValue($completed_habit_id, $new_value);
            $_SESSION['message'] = "Habit value has been reset to default value.";
        }
        
        /* Redirect to customize day with GET */
        redirect($app_path . 'my_habits/index.php?action=customize_day&month_id=' . $monthID . '&day_to_customize=' . $day_to_customize . '&month_name=' . $monthName);
        break; 

}



