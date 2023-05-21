<?php


    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    require_once '../database/tickets.class.php';
    require_once '../utils/session.php';

    $agentId = $_POST["agentId"];

    $db = getDatabaseConnection();

    unassignTickets($db, $agentId);
    deleteUser($db, $agentId);
    
    header("Location: ../pages/tickets.php");
    
    exit();
    
?>