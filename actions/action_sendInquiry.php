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

    // Retrieve the user ID and role from the session
    $userId = $_SESSION['userID'];
    $userRole = $_SESSION['role'];

    // Get the message from the form submission
    $message = $_POST['message'];

    // Get the ticket ID from the URL using $_GET
    if (!isset($_GET['id'])) {
        redirectBasedOnRole($userRole);
        exit();
    }
    $ticketId = $_GET['id'];

    // Create the inquiry/message in the database
    $inquiryId = createInquiry($db, (int)$ticketId, $userRole, $userId, $message);

    if ($inquiryId === false) {
        header("Location: ../pages/inquiries.php?error=1");
        exit();
    }

    // Redirect back to the inquiries page with the ticket ID
    header("Location: ../pages/inquiries.php?id=" . $ticketId);
    exit();
?>
