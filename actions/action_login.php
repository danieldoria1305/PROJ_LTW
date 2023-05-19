<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    require_once '../utils/session.php';
    require_once '../pages/redirect.php';
    require_once '../templates/login.tpl.php';

    $session = new Session();
    $session->init();

    $username_error = $email_error = $password_error = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $username_or_email = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $has_error = false;

        if (empty($username_or_email)) {
            $username_error = "Please enter your username or e-mail!";
            $has_error = true;
        }

        if (empty($password)) {
            $password_error = "Please enter your password!";
            $has_error = true;
        }

        if (!$has_error) {
            $db = getDatabaseConnection();

            $user = filter_var($username_or_email, FILTER_VALIDATE_EMAIL)
                ? getUserByEmail($db, $username_or_email)
                : getUserByUsername($db, $username_or_email);

            if (!$user) {
                $username_error = "User not found!";
                $has_error = true;
            } elseif (!getUserWithPassword($db, $user->username, $password)) {
                $password_error = "Incorrect password!";
                $has_error = true;
            } else {
                $_SESSION['userID'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;
                $session->setId($user->id);
                $session->setUsername($user->username);
                $session->setRole($user->role);

                $csrf_token = bin2hex(random_bytes(32));
                $_SESSION['csrf_token'] = $csrf_token;

                redirectBasedOnRole($user->role);
            }
        }

    }

    drawLogin($session, htmlspecialchars($username_error), htmlspecialchars($email_error), htmlspecialchars($password_error));
?>
