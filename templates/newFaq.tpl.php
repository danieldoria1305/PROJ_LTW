<?php function drawNewFaq(Session $session, $question_error = '', $answer_error = '') {

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - New FAQ</title>
        <link rel="stylesheet" href="../style/newTicket.css">
        <link rel="stylesheet" href="../style/header.css">
    </head>
    <body>
        <header>
            <h1><a href="../pages/index.php"> Ticketly</a> <span class="smaller">New FAQ</span></h1>
            <nav><ul>
                <li><a href="faq.php">Back to FAQ</a></li>
            </ul></nav>
        </header>

        <main>
            <h2>FAQ</h2>
            <form id="faq-form" action="../actions/action_newFaq.php" method="post">
                <label for="question">Question:</label>
                <textarea type="text" id="question" name="question" required></textarea>
                <?php if (!empty($question_error)) : ?>
                    <div class="error"><?php echo htmlspecialchars($question_error); ?></div>
                <?php endif; ?>
                
                <label for="answer">Answer:</label>
                <textarea type="text" id="answer" name="answer" required></textarea>
                <?php if (!empty($answer_error)) : ?>
                    <div class="error"><?php echo htmlspecialchars($answer_error); ?></div>
                <?php endif; ?>

                <button type="submit">Create</button>
            </form>
        </main>

        <?php include '../templates/footer.tpl.php';?>
    </body>
    </html>
<?php } ?>
