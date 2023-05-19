<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/inquiries.class.php';
    require_once '../pages/redirect.php';
    require_once '../utils/session.php';

    $session = new Session();

    if (!isset($session->username)) {
        header("Location: ../pages/index.php");
        exit();
    }

    $db = getDatabaseConnection();

    $userId = $_SESSION['userID'];
    $userRole = $_SESSION['role'];

    $message = $_POST['message'];

    if (!isset($_GET['id'])) {
        redirectBasedOnRole($userRole);
        exit();
    }
    $ticketId = $_GET['id'];

    $inquiryId = createInquiry($db, (int)$ticketId, $userRole, $userId, $message);

    if ($inquiryId === false) {
        header("Location: ../pages/inquiries.php?error=1");
        exit();
    }

    header("Location: ../pages/inquiries.php?id=" . $ticketId);
    exit();
?>
