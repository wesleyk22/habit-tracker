<!DOCTYPE html>
<?php if (isset($_SESSION['username'])) : ?>
    <p>Logged in as: <?php echo ($_SESSION['username']); ?></p>
<?php endif ?>
<form class="logout-button" action="/integrated_programming_project/habit_tracker/user_login/index.php" method="post">
    <input type="hidden" name="action" value="logout">
    <input type="submit" value="Log out">
</form>
<nav class="navbar">
    <ul>
        <li><a class="navbutton" href="/integrated_programming_project/habit_tracker/index.php">Home</a></li>
        <li><a class="navbutton" href="/integrated_programming_project/habit_tracker/my_habits/index.php">My Habits</a></li>
        <li><a class="navbutton" href="/integrated_programming_project/habit_tracker/customize_habits/index.php?action=habits_list">Customize Habits</a></li>
        <li><button onclick="toggleDarkMode()" class="navbutton">Light/Dark mode</button></li>
    </ul>
</nav>
<script>
    /* On initial page load, check if the user has a saved theme preference in localstorage: 
     * use the eventlistener with "DOMContentLoaded" to make sure all of the DOM content
     * is loaded before proceeding*/
    document.addEventListener("DOMContentLoaded", function() {
        const savedTheme = localStorage.getItem("color-theme");
        if (savedTheme == "dark") {
            toggleDarkMode();
        }
    });
    
    // Function to toggle on/off dark mode for the website
    function toggleDarkMode() {
        /* Body element is the only element that will have .dark-mode-one */
        const bodyElement = document.querySelector("body");
        bodyElement.classList.toggle("dark-mode-one");

        /* Elements to apply .dark-mode-two styling to */
        const darkModeTwoElements = [".calendar-day", "form", "table", ".navbar"];
        
        /* Apply .dark-mode-two styling to these elements */
        darkModeTwoElements.forEach((elementName) => {
            selectedElements = document.querySelectorAll(elementName);
            selectedElements.forEach((element) => {
                element.classList.toggle("dark-mode-two");
            });
        });

        /* Elements to apply .dark-mode-three styling to */
        const darkModeThreeElements = ["td", "input", ".navbutton", "select"];

        /* Apply .dark-mode-two styling to these elements */
        darkModeThreeElements.forEach((elementName) => {
            selectedElements = document.querySelectorAll(elementName);
            selectedElements.forEach((element) => {
                element.classList.toggle("dark-mode-three");
            });
        });

        /* If the dark mode is toggled on, save that setting in local storage */
        if (bodyElement.classList.contains("dark-mode-one")) {
            localStorage.setItem("color-theme", "dark");
        } else {
            localStorage.setItem("color-theme", "light");
        }

    }
</script>
