<?php function drawLogin(Session $session, $username_error = '', $email_error = '', $password_error = '') {?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - Log In</title>
        <link rel="stylesheet" href="../style/register.css">
        <link rel="stylesheet" href="../style/header.css">
    </head>
    <body>
        <header>
            <h1> <a href="../pages/index.php"> Ticketly</a> <span class="smaller">Log In</span></h1>
        </header>

        <main>
            <h2>Log In</h2>
            <form id="login-form" action="../actions/action_login.php" method="post">
                <label for="username">Username or E-mail:</label>
                <input type="text" id="username" name="username">
                <?php if (!empty($username_error) or !empty($email_error)) : ?>
                    <div class="error">
                        <?php 
                            echo $username_error; 
                            echo $email_error;
                        ?></div>
                <?php endif; ?>

                <label for="password">Password:</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" required>
                    <button id="password-toggle" type="button">Show</button>
                </div>
                <?php if (!empty($password_error)) : ?>
                    <div class="error"><?php echo $password_error; ?></div>
                <?php endif; ?>

                <button type="submit">Submit</button>

                <div class="NoAccount">
                    <p>Don't have an account? <a href="register.php">Register</a></p>
                </div>

            </form>
        </main>

        <?php include '../templates/footer.tpl.php';?>

        <script>
            const passwordField = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');

            passwordToggle.addEventListener('click', () => {
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    passwordToggle.textContent = 'Hide';
                } else {
                    passwordField.type = 'password';
                    passwordToggle.textContent = 'Show';
                }
            });
        </script>
        
    </body>
    </html>
<?php } ?>
