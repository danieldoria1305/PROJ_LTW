<?php function drawTicketLog(Session $session) {

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Ticketly - Ticket Log</title>
        <link rel="stylesheet" href="../style/listClients.css">
        <link rel="stylesheet" href="../style/header.css">
    </head>

    <body>
        <header>
            <h1>Ticketly <span class="smaller">Ticket Log</span></h1>
            <nav>
                <ul>
                    <li><a href="#" onclick="redirectToTickets('<?php echo $_SESSION['role']; ?>')">Back to Tickets</a></li>
                    <li><a href="../actions/action_logout.php">Log out</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <h2>Ticket Log</h2>
            <section id="ticket-log">
                <?php
                require_once '../database/connection.db.php';
                require_once '../database/ticketLogs.class.php';

                $db = getDatabaseConnection();
                $ticketID = $_GET['id'];

                $ticketLogs = getLogsByTicketId($db, $ticketID);

                if (empty($ticketLogs)) {
                    echo '<p>No logs found for this ticket.</p>';
                } else {
                    echo '<table>';
                    echo '<tr>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                            <th>Changes Done At</th>
                          </tr>';
                    foreach ($ticketLogs as $log) {
                        echo '<tr>';
                        echo '<td>' . $log->fieldName . '</td>';
                        echo '<td>' . $log->oldValue . '</td>';
                        echo '<td>' . $log->newValue . '</td>';
                        echo '<td>' . $log->createdAt . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
                ?>
            </section>
        </main>

        <?php include '../templates/footer.tpl.php'; ?>
        <script src="../javascript/redirect.js"></script>

    </body>

    </html>
<?php } ?>
