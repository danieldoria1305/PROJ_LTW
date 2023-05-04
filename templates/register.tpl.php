<?php function drawRegister(Session $session) { ?>
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
            <nav> <a href="index.php">Home</a> </nav>
        </header>
        
        <main>
            <h2>Register</h2>
            <form id="registration-form" action="../actions/action_register.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Submit</button>

            </form>
        </main>
        
        <?php include '../templates/footer.tpl.php';?>
        
    </body>
    </html>
<?php } ?>