<?php function drawEditFaq(Session $session, $question_error = '', $answer_error = '') {
    require_once '../database/connection.db.php';
    require_once '../database/faqs.class.php';
    
    $db = getDatabaseConnection();
    
    if (isset($_POST['faq_id'])) {
        $faqId = (int)$_POST['faq_id'];
    } elseif (isset($_GET['id'])) {
        $faqId = (int)$_GET['id'];
    } else {
        exit('Invalid FAQ ID');
    }
    
    $faq = getFaqEditData($db, (int)$faqId);
    
    if (empty($faq)) {
        exit('FAQ not found');
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - Edit FAQ</title>
        <link rel="stylesheet" href="../style/newTicket.css">
        <link rel="stylesheet" href="../style/header.css">
    </head>
    <body>
        <header>
            <h1><a href="../pages/index.php"> Ticketly</a> <span class="smaller">Edit FAQ</span></h1>
            <nav><ul>
                <li><a href="faq.php">Back to FAQ</a></li>
            </ul></nav>
        </header>

        <main>
            <h2>Edit FAQ</h2>
            <form id="faq-form" action="../actions/action_editFaq.php" method="post">
                <input type="hidden" name="faq_id" value="<?php echo $faq->id; ?>">
                <label for="question">Question:</label>
                <textarea type="text" id="question" name="question" required><?php echo $faq->question; ?></textarea>
                <?php if (!empty($question_error)) : ?>
                    <div class="error"><?php echo htmlspecialchars($question_error); ?></div>
                <?php endif; ?>
                
                <label for="answer">Answer:</label>
                <textarea type="text" id="answer" name="answer" required><?php echo $faq->answer; ?></textarea>
                <?php if (!empty($answer_error)) : ?>
                    <div class="error"><?php echo htmlspecialchars($answer_error); ?></div>
                <?php endif; ?>
                <button type="submit">Update</button>
            </form>
            <form id="delete-form" action="../actions/action_deleteFaq.php" method="post">
                <input type="hidden" name="faq_id" value="<?php echo $faq->id; ?>">
                <button type="submit">Delete</button>
            </form>
        </main>
        <?php include '../templates/footer.tpl.php';?>
    </body>
    </html>
    
<?php } ?>
