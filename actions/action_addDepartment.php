<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../database/connection.db.php';
    require_once __DIR__ . '/../database/departments.class.php';
    require_once '../utils/session.php';

    $session = new Session();

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
