<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../database/connection.db.php';
    require_once __DIR__ . '/../database/status.class.php';
    require_once '../utils/session.php';

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
            header('Location: ../pages/admin.php');
            exit();
        }
    }
    drawAdmin($session);

?>
