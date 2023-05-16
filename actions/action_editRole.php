<?php
    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';

    $clientId = $_POST['clientId'];
    $role = $_POST['role'];

    $db = getDatabaseConnection();
    $user = getUserById($db, $clientId);
    if ($user) {
        $user->role = $role;
        updateUserRole($db, $user->id, $role);
    }

    if ($role === 'client') {
        header("Location: ../pages/listClients.php");
    } elseif ($role === 'agent') {
        header("Location: ../pages/listAgents.php");
    } else {
        header("Location: ../pages/listClients.php");
    }

    exit();
?>
