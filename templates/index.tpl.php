<?php function drawIndex(Session $session){
    require_once '../database/connection.db.php';
    require_once '../database/faqs.class.php';

    $db = getDatabaseConnection();
    $faqs = getFaqData($db);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticketly</title>
        <link rel="stylesheet" href="../style/index.css">
        <link rel="stylesheet" href="../style/header.css">
    </head>

    <body>
        <header>
            <h1>Ticketly</h1>
            <nav>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section id="hero">
                <h2>Welcome to Ticketly</h2>
                <p>Submit a ticket to report an issue, track its progress and resolve it efficiently.</p>
            </section>
            <section id="faq">
                <h3>Frequently Asked Questions</h3>
                <ul>
                    <?php foreach ($faqs as $faq) : ?>
                        <li>
                            <h4><?php echo htmlspecialchars($faq->question); ?></h4>
                            <p><?php echo htmlspecialchars($faq->answer); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </main>
        <?php include '../templates/footer.tpl.php'; ?>
    </body>

    </html>
<?php } ?>
