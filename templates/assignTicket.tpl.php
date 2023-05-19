<?php function drawAssignTicket(Session $session) {
    
    session_start();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - Assign Agent</title>
        <link rel="stylesheet" href="../style/listClients.css">
        <link rel="stylesheet" href="../style/header.css">
        <script>
            function confirmAssign() {
                return confirm("Are you sure you want to assign this ticket to the selected agent?");
            }
        </script>
    </head>
    <body>
        <header>
            <h1>Ticketly <span class="smaller">Assign Agent</span></h1>
            <nav>
                <ul>
                    <li><a href="#" onclick="redirectToTickets('<?php echo $_SESSION['role']; ?>')">Back to Tickets</a></li>
                    <li><a href="../actions/action_logout.php">Log out</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <h2>Agents</h2>
            <section id="agents">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Assign</th>
                    </tr>
                    <?php
                        require_once '../database/connection.db.php';
                        require_once '../database/user.class.php';
                        
                        $db = getDatabaseConnection();
                        
                        $agents = getAgents($db);
                        
                        foreach ($agents as $agent) { ?>
                        <tr>
                            <td><?php echo $agent->name ?></td>
                            <td><?php echo $agent->username ?></td>
                            <td><?php echo $agent->email ?></td>
                            <td>
                                <form method="POST" action="../actions/action_assignTicket.php" onsubmit="return confirmAssign();">
                                    <input type="hidden" name="ticket_id" value="<?php echo $_GET['id']; ?>">
                                    <input type="hidden" name="agent_id" value="<?php echo $agent->id; ?>">
                                    <button type="submit" name="assign_ticket">Assign</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </main>

        <?php include '../templates/footer.tpl.php';?>
        <script src="../javascript/redirect.js"></script>

    </body>
    </html>
<?php } ?>
