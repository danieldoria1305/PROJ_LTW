<?php function drawListAgents(Session $session) {

    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/index.php");
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - Agents' List</title>
        <link rel="stylesheet" href="../style/listClients.css">
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this agent?");
            }
        </script>
    </head>
    <body>
        <?php include '../templates/header.tpl.php';?>
        <main>
            <h2>Agents</h2>
            <section id="agents">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Delete</th>
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
                            <td>
                                <form class="role-form" data-agent-id="<?php echo $agent->id ?>">
                                    <input type="hidden" name="clientId" value="<?php echo $agent->id ?>">
                                    <select class="role-select" name="role">
                                        <option value="client" <?php if ($agent->role == 'client') echo 'selected' ?>>Client</option>
                                        <option value="agent" <?php if ($agent->role == 'agent') echo 'selected' ?>>Agent</option>
                                        <option value="admin" <?php if ($agent->role == 'admin') echo 'selected' ?>>Admin</option>
                                    </select>
                                    <button type="submit">Save</button>
                                </form>
                            </td>
                            <td>
                            <?php
                                $departments = getDepartments($db);
                                $agentDepartment = getDepartmentsNameById($db, $agent->departmentId);
                            ?>
                            <form class="department-form" data-agent-id="<?php echo $agent->id ?>">
                                <input type="hidden" name="clientId" value="<?php echo $agent->id ?>">
                                <select class="department-select" name="departmentId">
                                <?php
                                    foreach ($departments as $department) {
                                        $selected = ($agent->departmentId == $department->id) ? 'selected' : '';
                                        echo '<option value="' . $department->id . '" ' . $selected . '>' . $department->name . '</option>';
                                    }
                                ?> 
                                </select>
                                <button type="submit">Save</button>
                            </form>
                            </td>
                            <td>
                                <form id="delete-form" method="post" action="../actions/action_deleteAgent.php" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="agentId" value="<?php echo $agent->id ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </main>

        <?php include '../templates/footer.tpl.php';?>
        <script src="../javascript/listAgents.js"></script>

    </body>
    </html>
<?php }?>
