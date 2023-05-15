<?php

    declare(strict_types=1);

    require_once '../database/connection.db.php';
    require_once '../database/user.class.php';
    require_once '../utils/session.php';
    require_once '../templates/register.tpl.php';

    $session = new Session();

    // Redirect to homepage if user is already logged in
    if (isset($session->username)) {
        header("Location: ../pages/client.php");
        exit();
    }

    // Initialize error messages
    $name_error = $username_error = $email_error = $password_error = '';

    // Process registration form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Get form data
        $name = trim($_POST["name"]);
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        // validate data
        $has_error = false;

        // name validation
        if (empty($name)) {
            $name_error = "Please enter your name!";
            $has_error = true;
        }

        // username validation
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

        // email validation
        if (empty($email)) {
            $email_error = "Please enter an email!";
            $has_error = true;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please enter a valid email!";
            $has_error = true;
        }

        // password validation
        if (empty($password)) {
            $password_error = "Please enter a password!";
            $has_error = true;
        } elseif (strlen($password) < 6 or strlen($password) > 15) {
            $password_error = "Password must be between 6 and 15 characters long!";
            $has_error = true;
        }

        // repeated data
        if (!$has_error) {
            $db = getDatabaseConnection();

            if (User::duplicateUsername($db, $username)) {
                $username_error = "Username already exists!";
                $has_error = true;
            }

            if (User::duplicateEmail($db, $email)) {
                $email_error = "Email already in use!";
                $has_error = true;
            }
        }

        if (!$has_error) {
            $UserID = User::createUser($db, $username, $password, $name, $email);
            $_SESSION['userID'] = $UserID;
            header('Location: ../pages/client.php');
        } else {
            drawRegister($session, $name_error, $username_error, $email_error, $password_error, $error_message);
        }
    }

    // Display registration form with errors (if any)
    else include_once '../templates/register.tpl.php';

?>