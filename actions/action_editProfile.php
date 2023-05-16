<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    require_once '../utils/session.php';
    require_once '../templates/myPage.tpl.php';

    $session = new Session();

    $name_error = $username_error = $email_error = $password_error = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($session->username)) {

        $name = trim($_POST["name"]);
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if (empty($name)) {
            $name_error = "Please enter your name!";
            $has_error = true;
        }

        if (empty($username)) {
            $username_error = "Please enter a username!";
            $has_error = true;
        } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $username_error = "Please enter valid characters only (characters or numbers)!";
            $has_error = true;
        } elseif (strlen($username) < 6 or strlen($username) > 15) {
            $username_error = "Username must be between 6 and 15 characters long!";
            $has_error = true;
        }

        var_dump($name_error, $username_error);

        if (empty($email)) {
            $email_error = "Please enter an email!";
            $has_error = true;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please enter a valid email!";
            $has_error = true;
        }

        if (empty($password)) {
            $password_error = "Please enter a password!";
            $has_error = true;
        } elseif (strlen($password) < 6 or strlen($password) > 15) {
            $password_error = "Password must be between 6 and 15 characters long!";
            $has_error = true;
        }

        if (!$has_error) {
            $db = getDatabaseConnection();
            $currentUser = getUserByUsername($db, $session->username);

            if ($currentUser !== null) {
                if ($currentUser->username !== $username && duplicateUsername($db, $username)) {
                    $username_error = "Username already exists!";
                    $has_error = true;
                }

                if ($currentUser->email !== $email && duplicateEmail($db, $email)) {
                    $email_error = "Email already in use!";
                    $has_error = true;
                }
            }
        }

        if (!$has_error) {
            $user = updateUser($db, $currentUser->id, $username, $password, $name, $email);
            header('Location: ../pages/client.php');
        }
    }

    drawMyPage($session, $name_error, $username_error, $email_error, $password_error);

?>