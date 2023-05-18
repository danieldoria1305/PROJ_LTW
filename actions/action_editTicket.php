<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/tickets.class.php';
    require_once '../utils/session.php';
    require_once '../templates/editTicket.tpl.php';

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
        $answer = isset($_POST["answer"]) ? trim($_POST["answer"]) : '';
        $department_id = isset($_POST["department_id"]) ? (int)$_POST["department_id"] : null;
        $priority = trim($_POST["priority"]);
        $ticketId = isset($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : null;

        if ($session->role === 'client') {

            $has_error = false;
            
            if (empty($title)) {
                $title_error = "Please enter a title!";
                $has_error = true;
            } elseif (strlen($title) < 5 || strlen($title) > 100) {
                $title_error = "Title must be between 5 and 100 characters long!";
                $has_error = true;
            }

            if (empty($description)) {
                $description_error = "Please enter a description!";
                $has_error = true;
            } elseif (strlen($description) < 10 || strlen($description) > 500) {
                $description_error = "Description must be between 10 and 500 characters long!";
                $has_error = true;
            }

            if (!$has_error) {
                $db = getDatabaseConnection();
                $ticket = getTicketEditData($db, $ticketId);
                updateTicket($db, $ticketId, $title, $description, $answer, $ticket->clientId, $ticket->agentId, $ticket->statusId, $priority, $department_id);
                header("Location: ../pages/client.php");
                exit();
            }

        } else {
            $db = getDatabaseConnection();
            $ticket = getTicketEditData($db, $ticketId);
            updateTicket($db, $ticketId, $ticket->title, $ticket->description, $answer, $ticket->clientId, $_SESSION['userID'], $ticket->statusId, $priority, $department_id);
            redirectBasedOnRole($session->role);
            exit();
        }
    }

    drawEditTicket($session, $title_error, $description_error);
?>
