<?php function drawRegister(Session $session, $name_error = '', $username_error = '', $email_error = '', $password_error = '') {?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - Registration</title>
        <link rel="stylesheet" href="../style/register.css">
        <link rel="stylesheet" href="../style/header.css">
    </head>
    <body>
        <header>
            <h1><a href="../pages/index.php"> Ticketly</a> <span class="smaller">Registration</span></h1>
        </header>

        <main>
            <h2>Register</h2>
            <form id="registration-form" action="../actions/action_register.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <?php if (!empty($name_error)) : ?>
                    <div class="error"><?php echo $name_error; ?></div>
                <?php endif; ?>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <?php if (!empty($username_error)) : ?>
                    <div class="error"><?php echo $username_error; ?></div>
                <?php endif; ?>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
                <?php if (!empty($email_error)) : ?>
                    <div class="error"><?php echo $email_error; ?></div>
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
