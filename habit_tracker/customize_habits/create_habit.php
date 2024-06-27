<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Create habit page
 */

// Set default variable on initial page load
if (!isset($user_has_habits)) {$user_has_habits = false; }
if (!isset($invalid_habit_message)) {$invalid_habit_message = ""; }

?>

<?php include '../view/header.php'; ?>
<body>
    <?php include '../view/navbar.php'; ?>
    <main>
        <div> 
            <h1>Create your habit:</h1>
            <p>Fill out the fields for creating a habit, and then click 'Submit'</p>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="submit_habit">
                <label for="habit_name">Habit name:<label>
                <input type="text" id="habit_name" name="habit_name">
                <label for="tracking_method">Tracked by:<label>
                <select name="tracking_method" id="tracking_method">
                    <option value="Time">Time</option>
                    <option value="DidOrDidnt">DidOrDidnt</option>
                    <option value="Number">Number</option>
                </select><br>   
                <?php if ($invalid_habit_message != "") : ?>
                    <p class="error"><?php echo $invalid_habit_message; ?></p>
                <?php endif ?>
                <input type="submit" value="Submit Habit">
            </form>
        </div>
    </main>
</body>
</html>