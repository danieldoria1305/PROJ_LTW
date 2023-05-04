<?php

declare(strict_types=1);

require_once '../utils/session.php';
require_once '../database/database.php';
require_once '../database/user.class.php';

// Redirect to homepage if user is already logged in
if (isset($session->username)) {
    header("Location: ../pages/index.php");
    exit();
}

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validate form data
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
        header("Location: ../pages/index.php");
        exit();
    }
}

// Display registration form with errors (if any)
include_once '../templates/register.tpl.php';
