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
                <h1>Ticketly <span class="smaller">Log In</span></h1>
                <nav><a href="../pages/index.php">Home</a></nav>
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
                    <input type="password" id="password" name="password" required>
                    <?php if (!empty($password_error)) : ?>
                        <div class="error"><?php echo $password_error; ?></div>
                    <?php endif; ?>

                    <button type="submit">Submit</button>

                    <!--<p>Forgot your password? <a href="reset_password.php">Reset it</a></p>!-->

                    <div class="NoAccount">
                        <p>Don't have an account? <a href="register.php">Register</a></p>
                    </div>

                </form>
            </main>

            <?php include '../templates/footer.tpl.php';?>
        </body>
    </html>
<?php } ?>
