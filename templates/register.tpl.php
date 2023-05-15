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
                <h1>Ticketly <span class="smaller">Registration</span></h1>
                <nav><a href="../pages/index.php">Home</a></nav>
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
                    <input type="password" id="password" name="password" required>
                    <?php if (!empty($password_error)) : ?>
                        <div class="error"><?php echo $password_error; ?></div>
                    <?php endif; ?>

                    <button type="submit">Submit</button>
                </form>
            </main>

            <?php include '../templates/footer.tpl.php';?>
        </body>
    </html>
<?php } ?>
