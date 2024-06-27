<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Habits list page
 */

// Set default variable on initial page load
if (!isset($users_habits)) {$users_habits = [];}
if (!isset($habits_list_message)) {$habits_list_message = '';}

?>

<?php include '../view/header.php'; ?>
<body>
    <?php include '../view/navbar.php'; ?>
    <main>
        <div>
            <?php if ($habits_list_message != "") : ?>
                <p><?php echo $habits_list_message; ?></p>
            <?php endif ?>
            <h1>Habits List</h1>
            <p>Welcome to the "My habits" page, here you can view habits that
                you have, and customize them. You may add, edit, delete any habit.</p>
            <h2>Global (Built-in) habits:</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Tracked by:</th>
                </tr>
                <?php foreach ($global_habits as $global_habit) : ?>
                <tr>
                    <td><?php echo $global_habit->getHabitName(); ?></td>
                    <td><?php echo $global_habit->getTrackingMethod(); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <h2>My habits:</h2>
            <?php if (!empty($users_habits)) : ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Tracked by:</th>
                </tr>
                <?php foreach ($users_habits as $user_habit) : ?>
                <tr>
                    <td><?php echo $user_habit->getHabitName(); ?></td>
                    <td><?php echo $user_habit->getTrackingMethod(); ?></td>
                    <td><form action="index.php" method="post">
                            <input type="hidden" name="action" value="delete_habit">
                            <input type ="hidden" name="habit_name" value="<?php echo $user_habit->getHabitName(); ?>">
                            <input type ="hidden" name="habit_id" value="<?php echo $user_habit->getHabitID(); ?>">
                            <input type="submit" class="delete-button" value=" " title="Delete habit">
                    </form></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else : ?>
            <p>Looks like you have no habits, if you would like to create one,
            click the 'Create New Habit' button below:</p>
            <?php endif; ?><br>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="create_habit">
                <input type="submit" value="Create New Habit">
            </form>
        </div>
    </main>
</body>
</html>