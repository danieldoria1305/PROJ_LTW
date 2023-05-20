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
    </head>

    <body>
        <?php include '../templates/header.tpl.php';?>

        <main>
            <a href="../pages/tickets.php" class="back-button"><</a>
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

    </body>

    </html>
<?php } ?>
