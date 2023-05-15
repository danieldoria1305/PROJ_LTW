<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    require_once '../utils/session.php';

    $session = new Session();

    // Redirect to homepage if user is already logged in
    if (isset($session->username)) {
        header("Location: ../pages/client.php");
        exit();
    }

    // Initialize error messages
    $username_error = $email_error = $password_error = '';

    // Process login form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Get form data
        $username_or_email = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Validate form data
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

            // Check if the input is an email or username and fetch the user data
            $user = filter_var($username_or_email, FILTER_VALIDATE_EMAIL)
                ? User::getUserByEmail($db, $username_or_email)
                : User::getUserByUsername($db, $username_or_email);

            if (!$user) {
                $username_error = "User not found!";
                $has_error = true;
            } elseif (!$user->getUserWithPassword($db, $user->username, $password)) {
                $password_error = "Incorrect password!";
                $has_error = true;
            } else {
                $_SESSION['userID'] = $user->id;
                header('Location: ../pages/client.php');
            }
        }

        if ($has_error) {
            require_once '../templates/login.tpl.php';
            drawLogin($session, $username_error, $email_error, $password_error);
        }
    }

    // Display login form with errors (if any)
    else require_once '../templates/login.tpl.php';

?>