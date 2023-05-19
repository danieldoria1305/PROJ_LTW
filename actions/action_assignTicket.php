<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../utils/session.php';
    require_once '../templates/assignTicket.tpl.php';
    require_once '../database/tickets.class.php';
    require_once '../database/ticketLogs.class.php';
    require_once '../pages/redirect.php';

    $session = new Session();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../database/connection.db.php';
        require_once '../database/tickets.class.php';

        $ticketID = (int)$_POST['ticket_id'];
        $agentID = (int)$_POST['agent_id'];

        $db = getDatabaseConnection();

        $ticket = getTicketById($db, $ticketID);

        if ($ticket) {
            $previousAgentID = $ticket->agentId;
            
            updateTicketAgent($db, $ticketID, $agentID);

            $log = new TicketLogs((int)$ticketID, (int)$ticketID, 'agentId', (string)$previousAgentID, (string)$agentID);
            $log->saveLog($db);

            redirectBasedOnRole($_SESSION['role']);
            exit();
        }
    }

    drawAssignTicket($session);

?>