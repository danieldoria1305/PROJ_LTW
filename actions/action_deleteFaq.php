<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/faqs.class.php';
    require_once '../utils/session.php';

    $session = new Session();

    if (isset($session->username)) {
        header("Location: ../pages/client.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $faqId = isset($_POST["faq_id"]) ? (int)$_POST["faq_id"] : (isset($_GET['id']) ? (int)$_GET['id'] : null);

        $db = getDatabaseConnection();

        deleteFaq($db, $faqId);
        header('Location: ../pages/faq.php');
        exit();
    }

    drawEditFaq($session);
?>