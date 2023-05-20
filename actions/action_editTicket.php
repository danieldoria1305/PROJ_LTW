<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/tickets.class.php';
    require_once '../database/ticketLogs.class.php';
    require_once '../utils/session.php';
    require_once '../templates/editTicket.tpl.php';
    require_once '../database/ticketHashtags.class.php';

    $session = new Session();

    if (!isset($session->username)) {
        header("Location: ../pages/index.php");
        exit();
    }

    $title_error = $description_error = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if ($session->role === 'client') {
            $title = isset($_POST["title"]) ? trim($_POST["title"]) : '';
            $description = isset($_POST["description"]) ? trim($_POST["description"]) : '';
        } else {
            $title = $description = null;
        }
        $answer = isset($_POST["answer"]) ? trim($_POST["answer"]) : null;
        $department_id = isset($_POST["department_id"]) ? (int)$_POST["department_id"] : null;
        $status_id = isset($_POST["status_id"]) ? (int)$_POST["status_id"] : null;
        $priority = trim($_POST["priority"]);
        $ticketId = isset($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : null;

        if ($session->role === 'client') {

            $has_error = false;

            if (empty($title)) {
                $title_error = "Please enter a title!";
                $session->addMessage('error', $title_error);
                $has_error = true;
            } elseif (strlen($title) < 5 || strlen($title) > 100) {
                $title_error = "Title must be between 5 and 100 characters long!";
                $session->addMessage('error', $title_error);
                $has_error = true;
            }

            if (empty($description)) {
                $description_error = "Please enter a description!";
                $session->addMessage('error', $description_error);
                $has_error = true;
            } elseif (strlen($description) < 10 || strlen($description) > 500) {
                $description_error = "Description must be between 10 and 500 characters long!";
                $session->addMessage('error', $description_error);
                $has_error = true;
            }

            if (!$has_error) {
                $db = getDatabaseConnection();
                $ticket = getTicketEditData($db, $ticketId);

                if ($ticket->title !== $title) {
                    $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'title', $ticket->title, $title);
                    $log->saveLog($db);
                }

                if ($ticket->description !== $description) {
                    $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'description', $ticket->description, $description);
                    $log->saveLog($db);
                }

                if ($ticket->departmentId !== $department_id) {
                    $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'department_id', (string)$ticket->departmentId, (string)$department_id);
                    $log->saveLog($db);
                }

                if ($ticket->statusId !== $status_id) {
                    $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'status_id', (string)$ticket->statusId, (string)$status_id);
                    $log->saveLog($db);
                }

                if ($ticket->priority !== $priority) {
                    $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'priority', $ticket->priority, $priority);
                    $log->saveLog($db);
                }

                updateTicket($db, $ticketId, $title, $description, $answer, $ticket->clientId, $ticket->agentId, $status_id, $priority, $department_id);
                header("Location: ../pages/client.php");
                exit();
            }

        } else {
            $db = getDatabaseConnection();
            $ticket = getTicketEditData($db, $ticketId);

            if ($ticket->answer !== $answer && $ticket->answer !== null) {
                $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'answer', $ticket->answer, $answer);
                $log->saveLog($db);
            }

            if ($ticket->departmentId !== $department_id) {
                $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'department_id', (string)$ticket->departmentId, (string)$department_id);
                $log->saveLog($db);
            }

            if ($ticket->statusId !== $status_id) {
                $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'status_id', (string)$ticket->statusId, (string)$status_id);
                $log->saveLog($db);
            }

            if ($ticket->priority !== $priority) {
                $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'priority', $ticket->priority, $priority);
                $log->saveLog($db);
            }

            updateTicket($db, $ticketId, $ticket->title, $ticket->description, $answer, $ticket->clientId, $_SESSION['userID'], $status_id, $priority, $department_id);
            
            $hashtags = isset($_POST['hashtags']) ? $_POST['hashtags'] : '';
            $selectedHashtags = explode(',', $hashtags);

            $del = deleteTicketHashtags($db, $ticketId);

            foreach ($selectedHashtags as $selectedHashtag) {
                $hashtagId = createHashtag($db, $selectedHashtag);
                createTicketHashtag($db, $ticketId, $hashtagId);
            }
            
            header("Location: ../pages/tickets.php");
            exit();
        }
    }

    drawEditTicket($session, $title_error, $description_error);
?>
