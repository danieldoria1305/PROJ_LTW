<?php function drawInquiries(Session $session) {
    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketly - Inquiries</title>
    <link rel="stylesheet" href="../style/inquiries.css">
</head>
<body>
    <?php include '../templates/header.tpl.php';?>

    <main>
        <a href="../pages/tickets.php" class="back-button"><</a>
        <h2>Inquiries</h2>
        <section id="chat">
            <ul class="message-list">
                <?php
                    require_once '../database/connection.db.php';
                    require_once '../database/user.class.php';
                    require_once '../database/inquiries.class.php';

                    $db = getDatabaseConnection();
                    $inquiries = getInquiries($db);
                    $ticketId = isset($_GET['id']) ? intval($_GET['id']) : null;

                    foreach ($inquiries as $inquiry) {
                        $userRole = $inquiry['user_role'];
                        $message = $inquiry['message'];
                        $inquiryTicketId = intval($inquiry['ticket_id']);
                        $isUserMessage = ($userRole === 'client');
                ?>
                <li class="<?= $isUserMessage ? 'user-message' : 'agent-message' ?>">
                    <span class="message-sender"><?= $isUserMessage ? 'Client' : 'Our Team' ?></span>
                    <span class="message-content"><?= $message ?></span>
                </li>
                <?php } ?>
            </ul>
        </section>
        
        <section id="new-message">
            <form action="../actions/action_sendInquiry.php?id=<?= $_GET['id'] ?>" method="post">
                <textarea name="message" placeholder="Type your message here"></textarea>
                <button type="submit">Send</button>
            </form>
        </section>
    </main>

    <?php include '../templates/footer.tpl.php'; ?>
</body>
</html>
<?php } ?>
