<?php
    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/status.class.php';
    require_once '../utils/session.php';
    require_once '../templates/tickets.tpl.php';

    $session = new Session();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newStatus = $_POST['newStatus'] ?? '';

        if ($newStatus !== '') {
            $db = getDatabaseConnection();
            $statusId = createStatus($db, $newStatus);
            header('Location: ../pages/tickets.php');
            exit();
        }
    }
    drawTickets($session);

?>
