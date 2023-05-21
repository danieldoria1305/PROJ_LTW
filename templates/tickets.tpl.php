<?php function drawTickets(Session $session) {

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }

    require_once '../database/tickets.class.php';
    require_once '../database/connection.db.php';
    require_once '../database/departments.class.php';
    require_once '../database/status.class.php';
    require_once '../database/hashtags.class.php';
    require_once '../database/ticketHashtags.class.php';
    require_once '../database/inquiries.class.php';
    require_once '../database/user.class.php';

    $clientId = $session->getId();
    $db = getDatabaseConnection();

    if ($session->role === 'admin'){
        $stmt = $db->prepare('SELECT * FROM tickets');
        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($session->role === 'client') {
        $stmt = $db->prepare('SELECT * FROM tickets WHERE client_id = ?');
        $stmt->execute([$clientId]);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $db->prepare('SELECT * FROM tickets WHERE agent_id = ?');
        $stmt->execute([$clientId]);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    ?>

    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>Ticketly - Tickets Area</title>
    <link rel="stylesheet" href="../style/tickets.css">
    </head>
    <body>
    <?php include '../templates/header.tpl.php';?>
    <main>
        <section id="my-tickets">
        <h2>Tickets</h2>
        <div class="filters">
            <?php if ($session->role !== 'client') : ?>
                <div id="hashtag-filter-container" class="filter-container">
                    <label for="hashtag-filter">Hashtag:</label>
                    <select id="hashtag-filter">
                        <option value="all">All</option>
                        <?php
                            $hashtags = getHashtags($db);
                            foreach ($hashtags as $hashtag) {
                                echo '<option value="' . $hashtag->id . '">' . $hashtag->name . '</option>';
                            }
                        ?>
                    </select>
                    <?php if ($session->role === 'admin') : ?>
                        <button id="add-hashtag" onclick="showFilterForm('hashtag')">+</button>
                        <div id="new-hashtag-form" style="display: none;">
                            <input type="text" id="new-hashtag-input" placeholder="Enter new hashtag">
                            <div class="button-group">
                                <button onclick="addHashtag()">Add</button>
                                <button onclick="cancelAddHashtag()">Cancel</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div id="department-filter-container" class="filter-container">
                <label for="department-filter">Department:</label>
                <select id="department-filter">
                    <option value="all">All</option>
                    <?php
                        $departments = getDepartments($db);
                        foreach ($departments as $department) {
                            echo '<option value="' . $department->id . '">' . $department->name . '</option>';
                        }
                    ?>
                </select>
                <?php if ($session->role === 'admin') : ?>
                    <button id="add-department" onclick="showFilterForm('department')">+</button>
                    <div id="new-department-form" style="display: none;">
                        <input type="text" id="new-department-input" placeholder="Enter new department">
                        <div class="button-group">
                            <button onclick="addDepartment()">Add</button>
                            <button onclick="cancelAddDepartment()">Cancel</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div id="status-filter-container" class="filter-container">
                <label for="status-filter">Status:</label>
                <select id="status-filter">
                    <option value="all">All</option>
                    <?php
                        $statuses = getStatus($db);
                        foreach ($statuses as $status) {
                            echo '<option value="' . $status->id . '">' . $status->name . '</option>';
                        }
                    ?>
                </select>
                <?php if ($session->role === 'admin') : ?>
                    <button id="add-status" onclick="showFilterForm('status')">+</button>
                    <div id="new-status-form" style="display: none;">
                        <input type="text" id="new-status-input" placeholder="Enter new status">
                        <div class="button-group">
                            <button onclick="addStatus()">Add</button>
                            <button onclick="cancelAddStatus()">Cancel</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($session->role !== 'client') : ?>
                <label for="priority-filter">Priority:</label>
                <select id="priority-filter">
                    <option value="all">All</option>
                    <option value="low">low</option>
                    <option value="medium">medium</option>
                    <option value="high">high</option>
                </select>
            <?php endif; ?>
            <button id="filter">Apply</button>
            <button id="undo-filter">Reset</button>
            <?php if ($session->role === 'client') : ?>
                <a href="newTicket.php" class="new-ticket-button">Create new ticket</a>
            <?php endif; ?>
        </div>
        <div class="ticket-container">
            <?php foreach ($tickets as $ticket) { ?>
                <?php
                    $ticketHashtags = getTicketHashtags($db, (int)$ticket['id']);
                    $hashtagCount = count($ticketHashtags);
                    $hashtagString = '';

                    foreach ($ticketHashtags as $index => $hashtag) {
                        $hashtagName = getHashtagsNameById($db, $hashtag->hashtagId);
                        $hashtagString .= $hashtagName;
                        if ($index < $hashtagCount - 1) {
                            $hashtagString .= ', ';
                        }
                    }
                ?>
                <div class="ticket" data-department="<?= $ticket['department_id'] ?>" data-status="<?= $ticket['status_id'] ?>" data-priority="<?= $ticket['priority'] ?>" data-hashtags="<?= $hashtagString ?>">
                    <div class="ticket-top">
                        <h3 class="ticket-subject"><?= $ticket['title'] ?></h3>
                        <?php
                            $ticketId = $ticket['id'];
                            $unansweredMessages = hasUnansweredMessages($db, $ticketId, $session->role);
                            $inquiriesButtonClass = $unansweredMessages ? 'unanswered-inquiries-button' : '';
                        ?>
                        <div class="edit-buttons">
                            <a href="inquiries.php?id=<?= $ticket['id'] ?>" class="edit-button <?= $inquiriesButtonClass ?>">Inquiries</a>
                            <?php if ($session->role === 'admin') : ?>
                                <a href="assignTicket.php?id=<?= $ticket['id'] ?>" class="edit-button">Assign</a>
                            <?php endif; ?>
                            <a href="editTicket.php?id=<?= $ticket['id'] ?>" class="edit-button">Edit</a>
                            <?php if ($session->role !== 'client') : ?>
                                <a href="ticketLog.php?id=<?= $ticket['id'] ?>" class="edit-button">Ticket log</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="ticket-info">
                        <span class="ticket-department">Department: <?= getDepartmentsNameById($db, $ticket['department_id']) ?></span>
                        <span class="ticket-status">Status: <?= getStatusNameById($db, $ticket['status_id']) ?></span>
                        <?php if ($session->role !== 'client') : ?>
                            <span class="ticket-priority">Priority: <?= $ticket['priority'] ?></span>
                        <?php endif; ?>
                        <span class="ticket-createdAt">Created at: <?= $ticket['created_at'] ?></span>
                        <span class="ticket-updatedAt">Last update at: <?= $ticket['updated_at'] ?></span>
                        <?php if ($session->role === 'admin') : ?>
                            <span class="ticket-agen">Assigned to: <?= getUserNameById($db, $ticket['agent_id']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="ticket-details">
                        <p class="ticket-summary"><strong>Description:</strong> <?= nl2br(htmlspecialchars($ticket['description'])) ?></p>
                        <p class="ticket-answer"><strong>Answer:</strong> <?= nl2br(htmlspecialchars($ticket['answer'])) ?></p>
                    </div>
                    <?php if ($session->role !== 'client') : ?>
                        <div class="ticket-info">
                            <span class="ticket-hashtags">Hashtags:
                                <?php
                                    $ticketHashtags = getTicketHashtags($db, $ticket['id']);
                                    $hashtagCount = count($ticketHashtags);
                                    foreach ($ticketHashtags as $index => $hashtag) {
                                        $hashtagName = getHashtagsNameById($db, $hashtag->hashtagId);
                                        echo $hashtagName;
                                        if ($index < $hashtagCount - 1) {
                                            echo ', ';
                                        }
                                    }
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php } ?>
            </section>
        </div>
    </main>
    <?php include '../templates/footer.tpl.php';?>
    <script> var userRole = '<?php echo $_SESSION['role']; ?>'; </script>
    <script src="../javascript/filterTickets.js"></script>
    <script src="../javascript/filterForms.js"></script>
    </body>
    </html>

<?php } ?>
