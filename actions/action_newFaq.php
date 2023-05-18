<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/faqs.class.php';
    require_once '../utils/session.php';
    require_once '../templates/newFaq.tpl.php';

    $session = new Session();

    if (!isset($session->username)) {
        header("Location: ../pages/index.php");
        exit();
    }

    $question_error = $answer_error = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $question = trim($_POST["question"]);
        $answer = trim($_POST["answer"]);

        $has_error = false;

        if (empty($question)) {
            $question_error = "Please enter a question!";
            $has_error = true;
        } elseif (strlen($question) < 15 or strlen($question) > 80) {
            $question_error = "Question must be between 15 and 80 characters long!";
            $has_error = true;
        }

        if (empty($answer)) {
            $answer_error = "Please enter an answer!";
            $has_error = true;
        } elseif (strlen($answer) < 15 or strlen($answer) > 250) {
            $answer_error = "Answer must be between 15 and 250 characters long!";
            $has_error = true;
        }

        if (!$has_error) {
            $db = getDatabaseConnection();
            $FaqId = createFaq($db, $question, $answer);
            header('Location: ../pages/faq.php');
            exit();
        }
    }

    drawNewFaq($session, $question_error, $answer_error);

?>