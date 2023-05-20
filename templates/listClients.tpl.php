<?php function drawListClients(Session $session) {

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - CLients' List</title>
        <link rel="stylesheet" href="../style/listClients.css">
    </head>
    <body>
        <?php include '../templates/header.tpl.php';?>

        <main>
            <h2>Clients</h2>
            <section id="clients">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Role</th>
                    </tr>
                    <?php
                        require_once '../database/connection.db.php';
                        require_once '../database/user.class.php';
                        
                        $db = getDatabaseConnection();
                        
                        $clients = getClients($db);
                        
                        foreach ($clients as $client) { ?>
                        <tr>
                            <td><?php echo $client->name ?></td>
                            <td><?php echo $client->username ?></td>
                            <td><?php echo $client->email ?></td>
                            <td>
                                <form method="post" action="../actions/action_editRole.php">
                                    <input type="hidden" name="clientId" value="<?php echo $client->id ?>">
                                    <select id="role" name="role">
                                        <option value="client" <?php if ($client->role == 'client') echo 'selected' ?>>Client</option>
                                        <option value="agent" <?php if ($client->role == 'agent') echo 'selected' ?>>Agent</option>
                                        <option value="admin" <?php if ($client->role == 'admin') echo 'selected' ?>>Admin</option>
                                    </select>
                                    <input type="submit" value="Save">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
        </main>

        <?php include '../templates/footer.tpl.php';?>

    </body>
    </html>
<?php } ?>
