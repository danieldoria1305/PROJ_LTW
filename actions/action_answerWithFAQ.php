<?php
declare(strict_types=1);

require_once '../database/connection.db.php';
require_once '../database/faqs.class.php';
require_once '../database/tickets.class.php';
require_once '../database/ticketLogs.class.php';
require_once '../utils/session.php';
require_once '../templates/faq.tpl.php';

$session = new Session();

if (!isset($session->username)) {
    header("Location: ../pages/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $ticketId = isset($_GET['ticket_id']) ? (int)$_GET['ticket_id'] : null;
    $faqId = isset($_GET['faq_id']) ? (int)$_GET['faq_id'] : null;

    $db = getDatabaseConnection();
    $ticket = getTicketEditData($db, $ticketId);
    $faq = getFaqDataById($db, $faqId);

    if ($ticket && $faq) {
        if (strpos($ticket->answer, "[FAQ]\n\nQuestion: " . $faq->question) === false) {
            $newAnswer = $ticket->answer . "\n\n[FAQ]\n\nQuestion: " . $faq->question . "\nAnswer: " . $faq->answer;
            $log = new TicketLogs($ticketId, $ticketId, 'answer', $ticket->answer, $newAnswer);
            $log->saveLog($db);

            updateTicket($db, $ticketId, $ticket->title, $ticket->description, $newAnswer, $ticket->clientId, $ticket->agentId, $ticket->statusId, $ticket->priority, $ticket->departmentId);
        }

        header("Location: ../pages/editTicket.php?id=$ticketId");
        exit();
    }
}

drawFaq($session);
exit();
?>
