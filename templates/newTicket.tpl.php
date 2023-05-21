<?php function drawNewTicket(Session $session, $title_error = '', $description_error = '') {

if (!isset($_SESSION['userID'])) {
    header("Location: ../pages/index.php");
    exit();
}
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
<?php } ?>
