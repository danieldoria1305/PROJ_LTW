<?php

    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/editFaq.tpl.php');

    drawEditFaq($session);
?>
