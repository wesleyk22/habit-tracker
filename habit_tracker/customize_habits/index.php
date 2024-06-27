<?php header("Cache-Control: no-cache"); 

 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Index / "Controller" for customize_habits
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

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'habits_list'; // Default page
    }
}

if (!isset($_SESSION['message'])){
    $_SESSION['message'] = '';
}

switch ($action) {
    case 'under_construction': 
        include('../under_construction.php');
        break;
    case 'habits_list':
        // Get the global habits (habits that any user can use)
        $global_habits = HabitsDB::getGlobalHabits();
        // Get users habits
        $users_habits = HabitsDB::getUsersHabits($userID);
        
        $habits_list_message = $_SESSION['message'];
        
        include('./habits_list.php');
        break; 
    case 'create_habit': 
        include('./create_habit.php');
        break;
    case 'submit_habit': 
        $habit_name = filter_input(INPUT_POST, 'habit_name');
        $tracking_method = filter_input(INPUT_POST, 'tracking_method') ;
        
        /* Check that habit name is not empty */
        if (empty($habit_name)) {
            $invalid_habit_message = "Please enter a name for the habit.";
            include('./create_habit.php');
            break;
        }
        
        /* Check if habit name already exists for that user */
        if (HabitsDB::userHasHabitByName($userID, $habit_name) == true){
            $invalid_habit_message = "Habit with that name for this user already exists. Please try again.";
            include('./create_habit.php');
            break;
        }
        
        /* Create a habit object to send as a parameter to the SubmitHabit function */
        $habit = new Habit();
        $habit->setUserID($userID);
        $habit->setHabitName($habit_name);
        $habit->setTrackingMethod($tracking_method);
        
        // Submit habit
        HabitsDB::SubmitHabit($habit);       
        // $habits_list_message = "Habit with name of " . $habit_name . " sucessfully created!";
        $_SESSION['message'] = "Habit with name of " . $habit_name . " sucessfully created!";

        /* Redirect to habits list with GET */
        redirect($app_path . 'customize_habits/index.php?action=habits_list');
        break;
    case 'delete_habit': 
        $habit_name = filter_input(INPUT_POST, 'habit_name');
        $habitID = filter_input(INPUT_POST, 'habit_id');
        
        /* Make sure that this habit name exists for this user */
        if (HabitsDB::userHasHabitByID($userID, $habitID) == true){
            
            // Delete all the related rows to this habit from the completedHabits table
            CompletedHabitsDB::deleteCompletedHabits($userID, $habitID);
                     
            // Delete the habit
            HabitsDB::deleteHabit($userID, $habitID);
            
            // $habits_list_message = "Habit sucessfully deleted";
            $_SESSION['message'] = "Habit sucessfully deleted";
        } else {
            // $habits_list_message = "Habit with name of " . $habit_name . " not found.";
            $_SESSION['message'] = "Habit with name of " . $habit_name . " not found.";
        }

        /* Redirect to habits list with GET */
        redirect($app_path . 'customize_habits/index.php?action=habits_list');
        // include('./habits_list.php');
        break;
}



