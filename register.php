<?php
require_once 'database/register.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register = new Register($db);

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['user-type'];

    // You can use either of the following methods to register the user
    // Method 1: Using createUser() method
    $userData = [
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'user-type' => $userType
    ];
    $result = $register->createUser($userData);

    // Method 2: Using registerUser() method
    // $register->registerUser($name, $username, $email, $password, $userType);

    if ($result) {
        // redirect to the appropriate page based on user type
        if ($userType === 'client') {
            header('Location: client.php');
        } elseif ($userType === 'agent') {
            header('Location: agent.php');
        } elseif ($userType === 'admin') {
            header('Location: admin.php');
        }
    } else {
        echo "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketly - Registration</title>
    <link rel="stylesheet" href="style/register.css">
    <link rel="stylesheet" href="style/header.css">
</head>
<body>
    <header>
        <h1>Ticketly <span class="smaller">Registration</span></h1>
        <nav> <a href="index.php">Home</a> </nav>
    </header>
    
    <main>
        <h2>Register</h2>
        <form id="registration-form" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label>Are you a client, an agent or an admin?</label>

            <div class="radio-group">
                <label for="client">Client:</label>
                <input type="radio" id="client" name="user-type" value="client" required>
                <label for="agent">Agent:</label>
                <input type="radio" id="agent" name="user-type" value="agent">
                <label for="admin">Admin:</label>
                <input type="radio" id="admin" name="user-type" value="admin">
            </div>

            <button type="submit">Submit</button>
        </form>
    </main>
    
    <?php include 'templates/footer.tpl.php';?>

    <script>
        const form = document.getElementById("registration-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            const userType = document.querySelector('input[name="user-type"]:checked').value;
            if (userType === "client") {
                window.location.href = "client.php";
            } else if (userType === "agent") {
                window.location.href = "agent.php";
            } else if (userType === "admin") {
                window.location.href = "admin.php";
            }
        });
    </script>
    
</body>
</html>
