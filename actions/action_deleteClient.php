<?php

    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    require_once '../database/tickets.class.php';
    require_once '../utils/session.php';
        
    $userId = $_POST["userId"];

    $db = getDatabaseConnection();

    deleteUser($db, $userId);
    deleteUserTickets($db, $userId);
    header("Location: ../pages/tickets.php");
    
    exit();
?>