<?php
    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/departments.class.php';
    require_once '../utils/session.php';

    $session = new Session();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newDepartment = $_POST['newDepartment'] ?? '';

        if ($newDepartment !== '') {
            $db = getDatabaseConnection();
            $departmentId = createDepartment($db, $newDepartment);
            header('Location: ../pages/admin.php');
            exit();
        }
    }

    drawAdmin($session);
?>
