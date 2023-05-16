<?php function drawMyPage(Session $session, $name_error = '', $username_error = '', $email_error = '', $password_error = '') {
    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    
    $db = getDatabaseConnection();
    
    $userId = $session->getId();

    if ($userId === null) {
        exit('User ID not found');
    }

    $user = getUserData($db, $userId);
    
    if ($user === null) {
        exit('User not found');
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - Edit Profile</title>
        <link rel="stylesheet" href="../style/myPage.css">
        <link rel="stylesheet" href="../style/header.css">
    </head>
    <body>
        <header>
            <h1>Ticketly <span class="smaller">Edit Profile</span></h1>
            <nav>
                <ul>
                    <li><a href="client.php">Back to My Tickets</a></li>
                    <li><a href="../actions/action_logout.php">Log out</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section id="edit-profile">
                <h2>Edit Profile</h2>
                <form id="edit-form" action="../actions/action_editProfile.php" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $user->name; ?>" required>
                    <?php if (!empty($name_error)) : ?>
                        <div class="error"><?php echo $name_error; ?></div>
                    <?php endif; ?>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $user->username; ?>" required>
                    <?php if (!empty($username_error)) : ?>
                        <div class="error"><?php echo $username_error; ?></div>
                    <?php endif; ?>

                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user->email; ?>" required>
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

                    <input type="submit" value="Save Changes">
                </form>
            </section>
        </main>

        <?php include '../templates/footer.tpl.php'; ?>

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
