<?php
    session_start();

    unset($_SESSION['userID']);

    header('Location: ../pages/index.php');
?>