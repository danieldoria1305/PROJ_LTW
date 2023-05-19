<?php function drawAgent(Session $session){?>
    <?php
        session_start();

        if (!isset($_SESSION['userID'])) {
            header("Location: ../pages/index.php");
        }

        require_once __DIR__ . '/../database/tickets.class.php';
        require_once __DIR__ . '/../database/connection.db.php';
        require_once __DIR__ . '/../database/departments.class.php';
        require_once __DIR__ . '/../database/status.class.php';

        $clientId = $session->getId();

        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM tickets');
        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>Ticketly - Agent Area</title>
    <link rel="stylesheet" href="../style/agent.css">
    <link rel="stylesheet" href="../style/header.css">
    </head>
    <body>
    <header>
        <h1>Ticketly <span class="smaller">Agent Area</span></h1>
        <nav>
        <ul>
            <li><a href="myPage.php">My Page</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="../actions/action_logout.php">Log out</a></li>
        </ul>
        </nav>
    </header>
    <main>
        <section id="my-tickets">
        <h2>Tickets</h2>
        <div class="filters">
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
            <label for="priority-filter">Priority:</label>
            <select id="priority-filter">
                <option value="all">All</option>
                <option value="low">low</option>
                <option value="medium">medium</option>
                <option value="high">high</option>
            </select>
            <button id="filter">Filter</button>
            <button id="undo-filter">Undo filters</button>
        </div>
        <?php foreach ($tickets as $ticket) { ?>
            <div class="ticket" data-department="<?= $ticket['department_id'] ?>" data-status="<?= $ticket['status_id'] ?>" data-priority="<?= $ticket['priority'] ?>">
                <div class="ticket-top">
                    <h3 class="ticket-subject"><?= $ticket['title'] ?></h3>
                    <div class="edit-buttons">
                        <a href="assignTicket.php?id=<?= $ticket['id'] ?>" class="edit-button">Assign</a>
                        <a href="editTicket.php?id=<?= $ticket['id'] ?>" class="edit-button">Edit</a>
                        <a href="ticketLog.php?id=<?= $ticket['id'] ?>" class="edit-button">Ticket log</a>
                    </div>
                </div>
                <div class="ticket-info">
                    <span class="ticket-department">Department: <?= getDepartmentsNameById($db, $ticket['department_id']) ?></span>
                    <span class="ticket-status">Status: <?= getStatusNameById($db, $ticket['status_id']) ?></span>
                    <span class="ticket-priority">Priority: <?= $ticket['priority'] ?></span>
                    <span class="ticket-createdAt">Created at: <?= $ticket['created_at'] ?></span>
                    <span class="ticket-updatedAt">Last update at: <?= $ticket['updated_at'] ?></span>
                </div>
                <div class="ticket-details">
                    <p class="ticket-summary"><strong>Description:</strong> <?= $ticket['description'] ?></p>
                    <p class="ticket-answer"><strong>Answer:</strong> <?= $ticket['answer'] ?></p>
                </div>
            </div>
        <?php } ?>
        </section>
    </main>
    <?php include '../templates/footer.tpl.php';?>
    <script src="../javascript/filterTickets.js"></script>
    </body>
    </html>

<?php } ?>
