<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    require_once '../utils/session.php';
    require_once '../database/tickets.class.php';
    require_once '../database/ticketLogs.class.php';

    $session = new Session();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
        exit();
    }

    $title_error = $description_error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $departmentId = trim($_POST['department_id']);
        $priority = trim($_POST['priority']);

        $has_error = false;

        if (empty($title)) {
            $title_error = "Please enter a title!";
            $has_error = true;
        } elseif (strlen($title) < 5 or strlen($title) > 80) {
            $title_error = "Title must be between 5 and 80 characters long!";
            $has_error = true;
        }

        if (empty($description)) {
            $description_error = "Please enter a description!";
            $has_error = true;
        } elseif (strlen($description) < 15 or strlen($description) > 350) {
            $description_error = "Description must be between 15 and 350 characters long!";
            $has_error = true;
        }

        if (!$has_error) {
            $clientId = $_SESSION['userID'];
            $db = getDatabaseConnection();

            $ticketId = createTicket($db, $title, $description, $clientId, $departmentId, $priority);

            $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'created_at', '', date('Y-m-d H:i:s'));
            $log->saveLog($db);

            header('Location: ../pages/client.php');
            exit();
        }
    }

    drawNewTicket($session, $title_error, $description_error);
?>
