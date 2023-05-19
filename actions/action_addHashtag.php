<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../database/connection.db.php';
    require_once __DIR__ . '/../database/hashtags.class.php';
    require_once '../utils/session.php';

    $session = new Session();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newHashtag = $_POST['newHashtag'] ?? '';

        if ($newHashtag !== '') {
            $db = getDatabaseConnection();
            $hashtagId = createHashtag($db, $newHashtag);
            header('Location: ../pages/admin.php');
            exit();
        }
    }
    drawAdmin($session);

?>
