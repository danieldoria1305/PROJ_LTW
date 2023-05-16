<?php
    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';

    $clientId = $_POST['clientId'];
    $departmentId = $_POST['departmentId'];

    $db = getDatabaseConnection();
    $user = getUserById($db, $clientId);
    if ($user) {
        $user->departmentId = $departmentId;
        updateUserDepartment($db, $user->id, $departmentId);
    }

    header("Location: ../pages/listAgents.php");

    exit();
?>
