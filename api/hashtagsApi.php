<?php

    declare(strict_types=1);

    require_once '../database/hashtags.class.php';
    require_once '../database/connection.db.php';
    require_once '../utils/session.php';

    $session = new Session();
    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $name = getHashtagsNameById($db, (int)$id);

        header('Content-Type: application/json');
        echo json_encode($name);
    }
?>
