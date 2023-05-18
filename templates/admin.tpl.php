<?php
function drawAdmin(Session $session)
{
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
<title>Ticketly - Admin Area</title>
<link rel="stylesheet" href="../style/admin.css">
<link rel="stylesheet" href="../style/header.css">
</head>
<body>
<header>
    <h1>Ticketly <span class="smaller">Admin Area</span></h1>
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
    <h2>Tickets</h2>
    <div class="filters">
        <div id="department-filter" class="filter-container">
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
            <button id="add-department" onclick="showAddDepartment()">+</button> <!-- Add department button -->
            <div id="new-department-form" style="display: none;">
                <input type="text" id="new-department-input" placeholder="Enter new department">
                <div class="button-group">
                    <button onclick="addDepartment()">Add</button>
                    <button onclick="cancelAddDepartment()">Cancel</button>
                </div>
            </div>
        </div>
        <div id="status-filter" class="filter-container">
            <label for="status-filter">Status:</label>
            <select id="status-filter">
                <option value="all">All</option> <!-- Added "all" option -->
                <?php
                    $statuses = getStatus($db);
                    foreach ($statuses as $status) {
                        echo '<option value="' . $status->id . '">' . $status->name . '</option>';
                    }
                ?>
            </select>
            <button id="add-status" onclick="showAddStatus()">+</button> <!-- Add status button -->
            <div id="new-status-form" style="display: none;">
                <input type="text" id="new-status-input" placeholder="Enter new status">
                <div class="button-group">
                    <button onclick="addStatus()">Add</button>
                    <button onclick="cancelAddStatus()">Cancel</button>
                </div>
            </div>
        </div>
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
    <div class="ticket-container">
        <?php foreach ($tickets as $ticket) { ?>
            <div class="ticket" data-department="<?= $ticket['department_id'] ?>" data-status="<?= $ticket['status_id'] ?>" data-priority="<?= $ticket['priority'] ?>">
                <div class="ticket-top">
                    <h3 class="ticket-subject"><?= $ticket['title'] ?></h3>
                    <a href="editTicket.php?id=<?= $ticket['id'] ?>" class="edit-button">Edit</a>
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
    </div>
</main>
<?php include '../templates/footer.tpl.php';?>

<script>
    function showAddDepartment() {
        var departmentForm = document.getElementById('new-department-form');
        departmentForm.style.display = 'block';
        var ticketContainer = document.querySelector('.ticket-container');
        ticketContainer.classList.add('open-form');
    }

    function cancelAddDepartment() {
        var departmentForm = document.getElementById('new-department-form');
        departmentForm.style.display = 'none';
        var newDepartmentInput = document.getElementById('new-department-input');
        newDepartmentInput.value = '';

        // Check if the status form is still open
        var statusForm = document.getElementById('new-status-form');
        if (!statusForm.style.display || statusForm.style.display === 'none') {
            var ticketContainer = document.querySelector('.ticket-container');
            ticketContainer.classList.remove('open-form');
        }
    }

    function addDepartment() {
        var newDepartmentInput = document.getElementById('new-department-input');
        var newDepartment = newDepartmentInput.value.trim();

        if (newDepartment !== '') {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // Refresh the page to update the department list
                    location.reload();
                }
            };
            xhttp.open('POST', '../actions/action_addDepartment.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send('newDepartment=' + newDepartment);
        }
    }

    function showAddStatus() {
        var statusForm = document.getElementById('new-status-form');
        statusForm.style.display = 'block';
        var ticketContainer = document.querySelector('.ticket-container');
        ticketContainer.classList.add('open-form');
    }

    function cancelAddStatus() {
        var statusForm = document.getElementById('new-status-form');
        statusForm.style.display = 'none';
        var newStatusInput = document.getElementById('new-status-input');
        newStatusInput.value = '';

        // Check if the department form is still open
        var departmentForm = document.getElementById('new-department-form');
        if (!departmentForm.style.display || departmentForm.style.display === 'none') {
            var ticketContainer = document.querySelector('.ticket-container');
            ticketContainer.classList.remove('open-form');
        }
    }

    function addStatus() {
        var newStatusInput = document.getElementById('new-status-input');
        var newStatus = newStatusInput.value.trim();

        if (newStatus !== '') {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // Refresh the page to update the status list
                    location.reload();
                }
            };
            xhttp.open('POST', '../actions/action_addStatus.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send('newStatus=' + newStatus);
        }
    }
</script>
</body>
</html>

<?php } ?>
