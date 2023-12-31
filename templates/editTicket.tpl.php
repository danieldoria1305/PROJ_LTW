<?php function drawEditTicket(Session $session, $title_error = '', $description_error = '') {

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }
    
    require_once '../database/connection.db.php';
    require_once '../database/tickets.class.php';
    require_once '../database/faqs.class.php';
    require_once '../database/ticketHashtags.class.php';

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
            <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this ticket?");
            }
        </script>
        </head>
        <body>
            <?php include '../templates/header.tpl.php';?>
            <main>
                <a href="../pages/tickets.php" class="back-button"><</a>
                <h2>Edit Ticket</h2>
                <form action="../actions/action_editTicket.php?id=<?php echo $ticketId; ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

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
                        <?php if ($session->role !== 'client') : ?>
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
                            <label for="hashtags">Hashtags:</label>
                            <div>
                                <div id="hashtags-top">
                                    <input type="text" id="hashtags-input" name="hashtags_input" placeholder="Type hashtags...">
                                    <button id="submit-hashtag" type="button">Add</button>
                                </div>
                                <div id="hashtags-autocomplete"></div>
                                <div id="hashtags-container">
                                    <?php
                                    $ticketHashtags = getTicketHashtags($db, $ticket->id);
                                    foreach ($ticketHashtags as $hashtag) {
                                        $hashtagName = getHashtagsNameById($db, $hashtag->hashtagId);
                                        echo '<span class="hashtag">' . $hashtagName . '<button class="remove-hashtag" type="button">X</button></span>';
                                    }
                                    ?>
                                </div>
                                
                                <input type="hidden" id="hashtags" name="hashtags" value="<?php echo implode(',', array_column($ticketHashtags, 'name')); ?>">
                            </div>
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
                <form id="delete-form" action="../actions/action_deleteTicket.php" method="post" onsubmit="return confirmDelete();">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket->id; ?>">
                    <button type="submit">Delete</button>
                </form>
            </main>
            <?php include '../templates/footer.tpl.php'; ?>
            <script src="../javascript/hashtagAutocomplete.js"></script>
            <script src="../javascript/addHashtag.js"></script>
        </body>
    </html>
<?php } ?>
