<?php

declare(strict_types=1);

require_once '../database/connection.db.php';
require_once '../database/tickets.class.php';
require_once '../utils/session.php';
require_once '../templates/editTicket.tpl.php';

$session = new Session();

if (isset($session->username)) {
    header("Location: ../pages/client.php");
    exit();
}

$title_error = $description_error = $answer_error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $department_id = isset($_POST["department_id"]) ? (int)$_POST["department_id"] : null;
    $priority = trim($_POST["priority"]);
    $ticketId = isset($_GET['id']) ? (int)$_GET['id'] : null;

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
        $ticket = getTicket($db, $ticketId);
        
        if ($ticket && ($session->role !== 'client' || $ticket->answer === '')) {
            $updatedTicket = new Ticket($ticket->id, $title, $description, $department_id, $priority, $ticket->answer);
            updateTicket($db, $updatedTicket);
            header('Location: ../pages/tickets.php');
            exit();
        }
    }
}

drawEditTicket($session, $title_error, $description_error, $answer_error);
?>
