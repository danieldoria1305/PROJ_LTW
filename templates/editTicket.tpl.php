<?php function drawEditTicket(Session $session, $title_error = '', $description_error = '') {

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }
    
    require_once '../database/connection.db.php';
    require_once '../database/tickets.class.php';
    require_once '../database/faqs.class.php';

    $db = getDatabaseConnection();

    if (isset($_POST['ticket_id'])) {
        $ticketId = (int)$_POST['ticket_id'];
    } elseif (isset($_GET['id'])) {
        $ticketId = (int)$_GET['id'];
    } else {
        exit('Invalid ticket ID');
    }

    $ticket = getTicketEditData($db, (int)$ticketId);

    if (empty($ticket)) {
        exit('Ticket not found');
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Ticketly - Edit Ticket</title>
            <link rel="stylesheet" href="../style/editTicket.css">
            <link rel="stylesheet" href="../style/header.css">
        </head>
        <body>
            <header>
                <h1>Ticketly <span class="smaller">Edit Ticket</span></h1>
                <nav>
                    <ul>
                        <li><a href="client.php">Back to Tickets</a></li>
                        <li><a href="../actions/action_logout.php">Log out</a></li>
                    </ul>
                </nav>
            </header>
            <main>
                <h2>Edit Ticket</h2>
                <form action="../actions/action_editTicket.php" method="post">
                    <div>
                        <label for="title">Title:</label>
                        <?php if ($session->role === 'client') : ?>
                            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($ticket->title); ?>" required>
                            <?php if (!empty($title_error)) : ?>
                                <div class="error"><?php echo htmlspecialchars($title_error); ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <span id="title"><?php echo htmlspecialchars($ticket->title); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="description">Description:</label>
                        <?php if ($session->role === 'client') : ?>
                            <textarea id="description" name="description" required><?php echo htmlspecialchars($ticket->description); ?></textarea>
                            <?php if (!empty($description_error)) : ?>
                                <div class="error"><?php echo htmlspecialchars($description_error); ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <span id="description"><?php echo htmlspecialchars($ticket->description); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="department">Department:</label>
                        <select id="department" name="department_id">
                            <option value="" <?php echo ($ticket->departmentId === null) ? 'selected' : ''; ?>>No Department</option>
                            <?php
                            include_once '../database/departments.class.php';
                            include_once '../database/connection.db.php';
                            $db = getDatabaseConnection();
                            $departments = getDepartments($db);
                            foreach ($departments as $department) {
                                $selected = ($department->id === $ticket->departmentId) ? 'selected' : '';
                                echo '<option value="' . $department->id . '" ' . $selected . '>' . $department->name . '</option>';
                            }
                            ?>
                        </select>
                        <label for="priority">Priority:</label>
                        <select id="priority" name="priority">
                            <?php
                            $priorities = array('low', 'medium', 'high');
                            foreach ($priorities as $priority) {
                                $selected = ($priority === $ticket->priority) ? 'selected' : '';
                                echo '<option value="' . $priority . '" ' . $selected . '>' . ucfirst($priority) . '</option>';
                            }
                            ?>
                        </select>
                        <?php if ($session->role !== 'client') : ?>
                            <label for="status">Status:</label>
                            <select id="status" name="status_id">
                                <?php
                                include_once '../database/status.class.php';
                                include_once '../database/connection.db.php';
                                $db = getDatabaseConnection();
                                $statuses = getStatus($db);
                                foreach ($statuses as $status) {
                                    $selected = ($status->id === $ticket->statusId) ? 'selected' : '';
                                    echo '<option value="' . $status->id . '" ' . $selected . '>' . $status->name . '</option>';
                                }
                                ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div class="form-answer">
                        <?php if ($session->role !== 'client') : ?>
                            <label for="answer">Answer:</label>
                            <div class="add-faq">
                                <a href="../pages/faq.php?ticket_id=<?php echo $ticket->id; ?>">Add FAQ to answer</a>
                            </div>
                            <textarea id="answer" name="answer"><?php echo htmlspecialchars($ticket->answer); ?></textarea>
                        <?php else: ?>
                            <label for="answer">Answer:</label>
                            <span id="answer-display"><?php echo htmlspecialchars($ticket->answer); ?></span>
                            <input type="hidden" name="answer" value="<?php echo htmlspecialchars($ticket->answer); ?>">
                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket->id; ?>">
                    <div class="form-row">
                        <input type="submit" value="Save Changes">
                    </div>
                </form>
                <form id="delete-form" action="../actions/action_deleteTicket.php" method="post">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket->id; ?>">
                    <button type="submit">Delete</button>
                </form>
            </main>
            <?php include '../templates/footer.tpl.php'; ?>
        </body>
    </html>
<?php } ?>
