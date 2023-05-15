<?php

declare(strict_types=1);

require_once '../database/connection.db.php';
require_once '../database/user.class.php';

// Redirect to homepage if user is already logged in

if (isset($session->username)) {
    header("Location: ../pages/client.php");
    exit();
}

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    require_once '../utils/session.php';
    $session = new Session();

    // Get form data
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // validate data
    $name_error = $username_error = $email_error = $password_error = "";
    $has_error = false;

    // name validation
    if (empty($name)) {
        $name_error = "Please enter your name.";
        $has_error = true;
    }

    // username validation
    if (empty($username)) {
        $username_error = "Please enter a username.";
        $has_error = true;
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $username_error = "Please enter valid characters";
        $has_error = true;
    } elseif (strlen($username) < 6 or strlen($username) > 15) {
        $username_error = "Username must be between 6 and 15 characters long";
        $has_error = true;
    }

    // email validation
    if (empty($email)) {
        $email_error = "Plesase enter an email";
        $has_error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $has_error = true;
    }

    // password validation
    if (empty($password)) {
        $email_error = "Please enter a password";
        $has_error = true;
    } elseif (strlen($password) < 6 or strlen($password) > 15) {
        $password_error = "Password must be between 6 and 15 characters long";
        $has_error = true;
    }

    // repeated data 
    if (!$has_error) {
        $db = getDatabaseConnection();

        if (duplicateUsername($db, $username)) {
            $username_error = "Username already exists";
            $has_error = true;
            error_log('ssss');
        }

        if(duplicateEmail($db, $email)) {
            $email_error = "Email already in use";
            $has_error = true;
        error_log('ssss');

        }
    }
    // nothing has errors
    if (!$has_error) {
        $UserID = createUser($db, $username, $password, $name, $email);
        $_SESSION['userID'] = $UserID;
        header('Location: ../pages/client.php');
    } else {
        $username_error = "Error...";
        $has_error = true;
    }

    // email validation

    // Validate form data
    /*
    $errors = [];
    if (empty($name)) {
        $errors[] = "Please enter your name.";
    }
    if (empty($username)) {
        $errors[] = "Please enter a username.";
    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $errors[] = "Username can only contain letters and numbers.";
    } elseif (strlen($username) > 30) {
        $errors[] = "Username cannot be longer than 30 characters.";
    } elseif (User::getUser($db, 0, $username)) {
        $errors[] = "Username already taken.";
    }
    if (empty($email)) {
        $errors[] = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($password)) {
        $errors[] = "Please enter a password.";
    }
    

    // If there are no errors, create the user and redirect to login page
    if (empty($errors)) {
        $user = User::createUser($db, [
            "name" => $name,
            "username" => $username,
            "password" => $password,
            "email" => $email,
            "role" => "client"
        ]);

        $session->username = $user->getUsername();
        $session->message("Registration successful! You are now logged in.");
        header("Location: ../pages/client.php");
        exit();
    }*/
}

// Display registration form with errors (if any)
include_once '../templates/register.tpl.php';
