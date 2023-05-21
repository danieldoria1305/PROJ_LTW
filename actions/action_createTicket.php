<?php

declare(strict_types=1);

require_once '../database/connection.db.php';
require_once '../database/user.class.php';
require_once '../utils/session.php';
require_once '../database/tickets.class.php';
require_once '../database/ticketLogs.class.php';

$session = new Session();

if (!isset($_SESSION['userID'])) {
    header("Location: ../pages/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $departmentId = trim($_POST['department_id']);
    $priority = trim($_POST['priority']);

    $title_error = '';
    $description_error = '';

    $has_error = false;

    if (empty($title)) {
        $title_error = "Please enter a title!";
        $session->addMessage('error', $title_error);
        $has_error = true;
    } elseif (strlen($title) < 5 or strlen($title) > 80) {
        $title_error = "Title must be between 5 and 80 characters long!";
        $session->addMessage('error', $title_error);
        $has_error = true;
    }

    if (empty($description)) {
        $description_error = "Please enter a description!";
        $session->addMessage('error', $description_error);
        $has_error = true;
    } elseif (strlen($description) < 15 or strlen($description) > 350) {
        $description_error = "Description must be between 15 and 350 characters long!";
        $session->addMessage('error', $description_error);
        $has_error = true;
    }

    if (!$has_error) {
        $clientId = $_SESSION['userID'];
        $db = getDatabaseConnection();

        $ticketId = createTicket($db, $title, $description, $clientId, $departmentId, $priority);

        $log = new TicketLogs((int)$ticketId, (int)$ticketId, 'created_at', '', date('Y-m-d H:i:s'));
        $log->saveLog($db);

        header('Location: ../pages/tickets.php');
        exit();
    }
}

// Function to draw the new ticket form
function drawNewTicket($session, $title_error = '', $description_error = '') {
    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
        exit();
    }

    // HTML code for the new ticket form
    ?>
    
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Ticketly - New Ticket</title>
            <link rel="stylesheet" href="../style/newTicket.css">
        </head>
        <body>
            <?php include '../templates/header.tpl.php';?>
            <main>
                <a href="../pages/tickets.php" class="back-button"><</a>
                <h2>New Ticket</h2>
                <form action="../actions/action_createTicket.php" method="post">
                    <div>
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required>
                        <?php if (!empty($title_error)) : ?>
                            <div class="error"><?php echo htmlspecialchars($title_error); ?></div>
                        <?php endif; ?>

                    </div>
                    <div>
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                        <?php if (!empty($description_error)) : ?>
                            <div class="error"><?php echo htmlspecialchars($description_error); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="form-row">
                        <label for="department">Department:</label>
                        <select id="department" name="department_id">
                            <option value="0">No Department</option>
                            <?php
                            require_once '../database/departments.class.php';
                            require_once '../database/connection.db.php';
                            $db = getDatabaseConnection();
                            $departments = getDepartments($db);
                            foreach ($departments as $department) {
                                echo '<option value="' . $department->id . '">' . $department->name . '</option>';
                            }
                            ?>
                        </select>
                        <label for="priority">Priority:</label>
                        <select id="priority" name="priority">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </main>
            <?php include '../templates/footer.tpl.php';?>
        </body>
    </html>
<?php }

drawNewTicket($session, $title_error, $description_error);
