<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    require_once '../utils/session.php';
    require_once '../templates/register.tpl.php';

    $session = new Session();
    $session->init();

    $name_error = $username_error = $email_error = $password_error = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = trim($_POST["name"]);
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        $has_error = false;

        if (empty($name)) {
            $name_error = "Please enter your name!";
            $session->addMessage('error', $name_error);
            $has_error = true;
        }

        if (empty($username)) {
            $username_error = "Please enter a username!";
            $session->addMessage('error', $username_error);
            $has_error = true;
        } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $username_error = "Please enter valid characters only (letters or numbers)!";
            $session->addMessage('error', $username_error);
            $has_error = true;
        } elseif (strlen($username) < 6 or strlen($username) > 15) {
            $username_error = "Username must be between 6 and 15 characters long!";
            $session->addMessage('error', $username_error);
            $has_error = true;
        }

        if (empty($email)) {
            $email_error = "Please enter an email!";
            $session->addMessage('error', $email_error);
            $has_error = true;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please enter a valid email!";
            $session->addMessage('error', $email_error);
            $has_error = true;
        }

        if (empty($password)) {
            $password_error = "Please enter a password!";
            $session->addMessage('error', $password_error);
            $has_error = true;
        } elseif (strlen($password) < 6 or strlen($password) > 15) {
            $password_error = "Password must be between 6 and 15 characters long!";
            $session->addMessage('error', $password_error);
            $has_error = true;
        }

        if (!$has_error) {
            $db = getDatabaseConnection();

            if (duplicateUsername($db, $username)) {
                $username_error = "Username already exists!";
                $session->addMessage('error', $username_error);
                $has_error = true;
            }

            if (duplicateEmail($db, $email)) {
                $email_error = "Email already in use!";
                $session->addMessage('error', $email_error);
                $has_error = true;
            }
        }

        if (!$has_error) {
            $UserID = createUser($db, $username, $password, $name, $email);
            $_SESSION['userID'] = $UserID;
            $user = getUserByID($db, $UserID);
            $_SESSION['username'] = $user->username;
            $session->setId($user->id);
            $session->setUsername($user->username);

            $_SESSION['role'] = "client";

            $csrf_token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrf_token;

            header('Location: ../pages/tickets.php');
        }
    }

    drawRegister($session, htmlspecialchars($name_error), htmlspecialchars($username_error), htmlspecialchars($email_error), htmlspecialchars($password_error));
?>
