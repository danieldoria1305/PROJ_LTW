<?php function drawFaq(Session $session) {

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }
    
    require_once '../database/connection.db.php';
    require_once '../database/faqs.class.php';
    
    $db = getDatabaseConnection();
    $faqs = getFaqData($db);
    $fromEditTicket = isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'editTicket.php') !== false;
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
            <h1>Ticketly <span class="smaller">FAQ</span></h1>
            <nav>
                <ul>
                    <li><a href="client.php">Back to Tickets</a></li>
                    <li><a href="../actions/action_logout.php">Log out</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section id="faq">
                <h3>Frequently Asked Questions</h3>
                <ul>
                    <?php foreach ($faqs as $faq) : ?>
                        <li>
                            <h4><?php echo htmlspecialchars($faq->question); ?></h4>
                            <p><?php echo htmlspecialchars($faq->answer); ?></p>
                            <?php if ($session->role !== 'client') : ?>
                                <?php if ($fromEditTicket) : ?>
                                    <a href="../actions/action_answerWithFAQ.php?faq_id=<?php echo $faq->id; ?>&ticket_id=<?php echo $_GET['ticket_id']; ?>" class="use-faq-button">Use FAQ</a>
                                <?php endif; ?>
                                <a href="editFaq.php?id=<?php echo $faq->id; ?>" class="edit-button">Edit</a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if ($session->role !== 'client') : ?>
                    <div class="create-faq">
                        <a class="button" href="newFaq.php">Create new FAQ</a>
                    </div>
                <?php endif; ?>
            </section>
        </main>
        <?php include '../templates/footer.tpl.php';?>
    </body>
    </html>

<?php } ?>