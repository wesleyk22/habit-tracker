<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Customize day page
 */

// Set default variable on initial page load
if (!isset($users_habits)) {$users_habits = [];}
if (!isset($completed_habits_for_this_day)) {$completed_habits_for_this_day = [];}
if (!isset($customize_day_message)) {$customize_day_message = '';}


//print_r($completed_habits_for_this_day); // for debugging

?>

<?php include '../view/header.php'; ?>
<body>
    <?php include '../view/navbar.php'; ?>
    <main>
        <div> 
            <?php if ($customize_day_message != "") : ?>
                <p><?php echo $customize_day_message; ?></p>
            <?php endif ?>
            <h1>Customizing: <?php echo $month_name; ?> <?php echo $day_to_customize; ?></h1>  
            <?php if (!empty($completed_habits_for_this_day)) : ?>
                <p>Add or remove habits associated with this day below:</p>
                <table>
                <tr>
                    <th>Habit</th>
                    <th>Tracking Method</th>
                    <th>Value</th>
                    <th>Modify Value</th>
                    <th>Delete</th>
                    <th>Reset</th>
                </tr>
                <?php foreach ($completed_habits_for_this_day as $completed_habit) : ?>
                    <tr>
                        <td><?php echo $completed_habit->getHabitName(); ?></td>
                        <td><?php echo $completed_habit->getTrackingMethod(); ?></td>
                        <td><?php echo $completed_habit->getHabitValue(); ?></td>
                        <td><form action="index.php" method="post">
                                <input type="hidden" name="action" value="update_habit_value">
                                <input type="hidden" name="completed_habit_id" value="<?php echo $completed_habit->getCompletedHabitID(); ?>">
                                <input type="hidden" name="day_to_customize" value="<?php echo $day_to_customize; ?>">
                                <input type="hidden" name="tracking_method" value="<?php echo $completed_habit->getTrackingMethod(); ?>">
                                <input type="hidden" name="habit_value" value="<?php echo $completed_habit->getHabitValue(); ?>">
                                
                                <?php if ($completed_habit->getTrackingMethod() == "Time") : ?>
                                    <label for="add_time">Add time (hh:mm:ss):<label>
                                    <input type="text" id="add_time" name="add_time" pattern="\d{1,2}:\d{1,2}:\d{1,2}" required value="00:00:00">
                                    <label for="subtract_time">Subtract time (hh:mm:ss):<label>
                                    <input type="text" id="subtract_time" name="subtract_time" pattern="\d{1,2}:\d{1,2}:\d{1,2}" required value="00:00:00">
                                    <input type="submit" value="Update">
                                <?php endif ?> 
                                
                                <?php if ($completed_habit->getTrackingMethod() == "Number") : ?>
                                    <label for="add">Add:<label>
                                    <input type="text" id="add" name="add" value="0">
                                    <label for="add">Subtract:<label>
                                    <input type="text" id="subtract" name="subtract" value="0">
                                    <input type="submit" value="Update">
                                <?php endif ?> 
                                
                                <?php if ($completed_habit->getTrackingMethod() == "DidOrDidnt") : ?>
                                    <?php if ($completed_habit->getHabitValue() == "Didnt" || $completed_habit->getHabitValue() == '') : ?>
                                        <input type ="hidden" name="new_value" value="Did">   
                                    <?php else : ?>
                                        <input type ="hidden" name="new_value" value="Didnt">  
                                    <?php endif ?>
                                    
                                    <input type="submit" value="Mark as did/didn't">
                                <?php endif ?> 
                                 
                        </form></td>
                        <td><form action="index.php" method="post">
                            <input type="hidden" name="action" value="update_habit_value">
                            <input type="hidden" name="completed_habit_id" value="<?php echo $completed_habit->getCompletedHabitID(); ?>">
                            <input type="hidden" name="day_to_customize" value="<?php echo $day_to_customize; ?>">
                            <input type="hidden" name="action" value="remove_completed_habit">
                            <input type="submit" class="delete-button" value=" " title="Remove Completed Habit">
                        </form></td>
                        <td><form action="index.php" method="post">
                            <input type="hidden" name="action" value="reset_habit_value">
                            <input type="hidden" name="completed_habit_id" value="<?php echo $completed_habit->getCompletedHabitID(); ?>">
                            <input type="hidden" name="day_to_customize" value="<?php echo $day_to_customize; ?>">
                            <input type="hidden" name="tracking_method" value="<?php echo $completed_habit->getTrackingMethod(); ?>">
                            <input type="hidden" name="action" value="reset_habit_value">
                            <input type="submit" class="reset-button" value=" " title="Reset To Default Value">
                        </form></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php else : ?>
                <p>Looks like there are no habits associated with this day, you
                can add a habit to this day using the drop down menu below, after it's added,
                you can then update the value of it.</p>
            <?php endif; ?><br>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="add_completed_habit">
                <input type ="hidden" name="day_to_customize" value="<?php echo $day_to_customize; ?>">
                <select name ="habit_id" id="habit_id">
                    <?php foreach ($global_habits as $global_habit) : ?>
                        <option value="<?php echo $global_habit->getHabitID(); ?>"><?php echo $global_habit->getHabitName(); ?></option>
                    <?php endforeach; ?>
                    <?php foreach ($users_habits as $user_habit) : ?>
                         <option value="<?php echo $user_habit->getHabitID(); ?>"><?php echo $user_habit->getHabitName(); ?></option>       
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Add Completed Habit">
            </form>

        </div>
    </main>
</body>
</html>