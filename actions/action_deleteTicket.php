<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/tickets.class.php';
    require_once '../utils/session.php';

    $session = new Session();

    if (!isset($session->username)) {
        header("Location: ../pages/index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $ticketId = isset($_POST["ticket_id"]) ? (int)$_POST["ticket_id"] : (isset($_GET['id']) ? (int)$_GET['id'] : null);

        $db = getDatabaseConnection();

        deleteTicket($db, $ticketId);
        header("Location: ../pages/tickets.php");
        
        exit();
    }

    drawEditTicket($session);
?>