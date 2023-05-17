<?php function drawClient(Session $session){?>
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
        $stmt = $db->prepare('SELECT * FROM tickets WHERE client_id = ?');
        $stmt->execute([$clientId]);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Ticketly - Client Area</title>
            <link rel="stylesheet" href="../style/client.css">
            <link rel="stylesheet" href="../style/header.css">
        </head>
        <body>
            <header>
                <h1>Ticketly <span class="smaller">Client Area</span></h1>
                <nav>
                    <ul>
                        <li><a href="myPage.php">My Page</a></li>
                        <li><a href="listClients.php">Clients' List</a></li>
                        <li><a href="listAgents.php">Agents' List</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="../actions/action_logout.php">Log out</a></li>
                    </ul>
                </nav>
            </header>
            <main>
                <section id="my-tickets">
                    <h2>My Tickets</h2>
                    <div class="filters">
                        <label for="department-filter">Filter by Department:</label>
                        <select id="department-filter">
                            <?php
                                $departments = getDepartments($db);
                                foreach ($departments as $department) {
                                    echo '<option value="' . $department->id . '">' . $department->name . '</option>';
                                }
                            ?>
                        </select>
                        <label for="status-filter">Filter by Status:</label>
                        <select id="status-filter">
                            <?php
                                $statuses = getStatus($db);
                                foreach ($statuses as $status) {
                                    echo '<option value="' . $status->id . '">' . $status->name . '</option>';
                                }
                            ?>
                        </select>
                        <a href="newTicket.php" class="new-ticket-button">Create new ticket</a>
                    </div>
                    <?php foreach ($tickets as $ticket) { ?>
                        <div class="ticket" data-department="<?= $ticket['department'] ?>" data-status="<?= $ticket['status'] ?>">
                            <h3 class="ticket-subject"><?= $ticket['title'] ?></h3>
                            <div class="ticket-info">
                                <span class="ticket-id">ID: <?= $ticket['id'] ?></span>
                                <span class="ticket-department">Department: <?= getDepartmentsNameById($db, $ticket['department_id']) ?></span>
                                <span class="ticket-status">Status: <?= $ticket['status'] ?></span>
                                <span class="ticket-priority">Priority: <?= $ticket['priority'] ?></span>
                                <span class="ticket-createdAt">Created at: <?= $ticket['created_at'] ?></span>
                                <span class="ticket-updatedAt">Last update at: <?= $ticket['updated_at'] ?></span>
                            </div>
                            <p class="ticket-summary"><?= $ticket['description'] ?></p>
                        </div>
                    <?php } ?>
                </section>
            </main>
            <?php include '../templates/footer.tpl.php';?>
        </body>
    </html>
<?php } ?>
