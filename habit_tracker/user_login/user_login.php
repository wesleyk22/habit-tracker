<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Login page
 */


if (!isset($invalid_user_message)) {
   $invalid_user_message = ""; // Set default variable for initial page load
}

if (!isset($account_creation_success_message)) {
   $account_creation_success_message = ""; // Set default variable for initial page load
}

// for testing
//foreach ($_SESSION as $key => $value) {
//    echo "$key: $value<br>";
//}

?>

<?php include '../view/header.php'; ?>
    <body>
        <main>
            <div>
                <?php if ($account_creation_success_message != "") : ?>
                        <p><?php echo $account_creation_success_message; ?></p>
                    <?php endif ?>
                <h1>Login</h1>
                <p>Login with a username/password, or create new account</p>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="login_attempt">
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username"><br>
                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password"><br>
                    <input type="submit" value="Login"><br>
                    <?php if ($invalid_user_message != "") : ?>
                        <p class="error"><?php echo $invalid_user_message; ?></p>
                    <?php endif ?>
                </form><br>
                
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="create_account">
                    <input type="submit" value="Create Account">
                </form>
            </div>
        </main>
    </body>
</html>