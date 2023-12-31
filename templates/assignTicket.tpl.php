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
        <script>
            function confirmAssign() {
                return confirm("Are you sure you want to assign this ticket to the selected agent?");
            }
        </script>
    </head>
    <body>
        <?php include '../templates/header.tpl.php';?>
        <main>
            <a href="../pages/tickets.php" class="back-button"><</a>
            <h2>Agents</h2>
            <section id="agents">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Assign</th>
                    </tr>
                    <?php
                        require_once '../database/connection.db.php';
                        require_once '../database/user.class.php';
                        require_once '../database/departments.class.php';
                        
                        $db = getDatabaseConnection();
                        
                        $agents = getAgents($db);
                        
                        foreach ($agents as $agent) { ?>
                        <tr>
                            <td><?php echo $agent->name ?></td>
                            <td><?php echo $agent->username ?></td>
                            <td><?php echo $agent->email ?></td>
                            <td><?php echo getDepartmentsNameById($db, $agent->departmentId) ?></td>
                            <td>
                                <form method="POST" action="../actions/action_assignTicket.php" onsubmit="return confirmAssign();">
                                    <input type="hidden" name="ticket_id" value="<?php echo $_GET['id']; ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> 
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

    </body>
    </html>
<?php } ?>
