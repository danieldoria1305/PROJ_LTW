<?php function drawListAgents(Session $session) {?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ticketly - Agents' List</title>
        <link rel="stylesheet" href="../style/listClients.css">
        <link rel="stylesheet" href="../style/header.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.role-form').submit(function(event) {
                    event.preventDefault();

                    var form = $(this);
                    var agentId = form.data('agent-id');
                    var roleSelect = form.find('.role-select');
                    var selectedRole = roleSelect.val();

                    $.ajax({
                        url: '../actions/action_editRole.php',
                        type: 'POST',
                        data: {
                            clientId: agentId,
                            role: selectedRole
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });

                $('.department-form').submit(function(event) {
                    event.preventDefault();

                    var form = $(this);
                    var agentId = form.data('agent-id');
                    var departmentSelect = form.find('.department-select');
                    var selectedDepartment = departmentSelect.val();

                    $.ajax({
                        url: '../actions/action_editDepartment.php',
                        type: 'POST',
                        data: {
                            clientId: agentId,
                            departmentId: selectedDepartment
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <header>
            <h1>Ticketly <span class="smaller">Agents' List</span></h1>
            <nav>
                <ul>
                    <li><a href="../pages/client.php">Back to My Tickets</a></li>
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
                        <th>E-mail</th>
                        <th>Role</th>
                        <th>Department</th>
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
                                    <input type="submit" value="Save">
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
                                <input type="submit" value="Save">
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
<?php }?>
