<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Completed habits page
 */

// Set default variable on initial page load
if (!isset($users_completed_habits)) {$users_completed_habits = [];}
if (!isset($completed_habits_list_message)) {$completed_habits_list_message = '';}


?>

<?php include '../view/header.php'; ?>
<body>
    <?php include '../view/navbar.php'; ?>
    <main>
        <div>
            <h1>My Completed Habits</h1>
            <p>Welcome to the "My Completed habits" page, here you can view habits that
               you have completed by week, month, year, etc. You can also submit any of 
               your habits to any of the days as a "completed habit" with a value.</p>
            <h2>Your completed habits for <?php echo $currentMonthName; ?>:</h2>
            <div class="calendar">
                <?php foreach ($calendarDays as $calendarDay) : ?>
                    <h3><?php echo $calendarDay ?></h3>
                <?php endforeach ?>
                <?php for ($i = 1; $i <= $grayedDays; $i++) : ?>
                    <div class="grayed-calendar-day"></div>
                <?php endfor ?>
                <?php for ($i = 1; $i <= $daysInMonth; $i++) : ?>
                <?php if ($i == $currentDay) : ?>
                    <div class="calendar-day today">
                <?php else : ?>
                    <div class="calendar-day">
                <?php endif; ?>
                    <h3><?php echo $i; ?></h3>
                    <?php foreach ($users_completed_habits as $completed_habit) : ?>
                        <?php if ($completed_habit->getDayCompleted() == $i) : ?>
                        <p><?php echo $completed_habit->getHabitName(); ?> - <?php echo $completed_habit->getHabitValue(); ?> </p>
                        <?php endif ?>
                    <?php endforeach ?>
                    <form action="index.php" method="get">
                            <input type="hidden" name="action" value="customize_day">
                            <input type ="hidden" name="month_id" value="<?php echo $currentMonthID; ?>">
                            <input type ="hidden" name="day_to_customize" value="<?php echo $i; ?>">
                            <input type ="hidden" name="month_name" value="<?php echo $currentMonthName; ?>">
                            <input type="submit" value="Customize">
                    </form>
                </div>
                <?php endfor ?>
            </div>
        </div>
    </main>
</body>
</html>