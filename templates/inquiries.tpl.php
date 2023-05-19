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
    <link rel="stylesheet" href="../style/header.css">
</head>
<body>
    <header>
        <h1>Ticketly <span class="smaller">Inquiries</span></h1>
        <nav>
            <ul>
                <li><a href="#" onclick="redirectToTickets('<?php echo $_SESSION['role']; ?>')">Back to Tickets</a></li>
                <li><a href="../actions/action_logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>

    <main>
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
                    <span class="message-sender"><?= $isUserMessage ? 'Client' : 'Agent' ?></span>
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
    <script src="../javascript/redirect.js"></script>
</body>
</html>
<?php } ?>
