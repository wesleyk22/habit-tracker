<?php header("Cache-Control: no-cache"); 
 /*
 * Wesley Keller
 * CIS 255 Web App Programming
 * 255 Integrated Programming Project
 * 4/29/2024
 * Account Creation Page
 */

// Default variables for initial page load
if (!isset($invalid_create_message)) {$invalid_create_message = '';}
if (!isset($username)) {$username = '';}
if (!isset($password)) {$password = '';}

?>

<?php include '../view/header.php'; ?>
    <body>
        <main>
            <div>
                <h1>Account Creation</h1>
                <p>Create an account with a username and password:</p>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="account_create_attempt">
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username"
                           value="<?php echo $username; ?>"><br>
                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password"
                           value="<?php echo $password; ?>"><br>
                    <input type="submit" value="Create This Account"><br>
                    <?php if ($invalid_create_message != "") : ?>
                        <p class="error"><?php echo $invalid_create_message; ?></p>
                    <?php endif ?>
                </form><br>
            </div>
        </main>
    </body>
</html>