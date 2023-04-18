<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ticketly - Client Area</title>
        <link rel="stylesheet" href="style/client.css">
        <link rel="stylesheet" href="style/header.css">
    </head>
    <body>
        <header>
            <h1>Ticketly <span class="smaller">Client Area</span></h1>
            <nav>
                <ul>
                    <li><a href="myPage.html">My Page</a></li>
                    <li><a href="index.html">Log out</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section id="my-tickets">
                <h2>My Tickets</h2>
                <div class="filters">
                    <label for="department-filter">Filter by Department:</label>
                    <select id="department-filter">
                        <option value="all">All Departments</option>
                        <option value="accounting">Accounting</option>
                        <option value="support">Support</option>
                    </select>
                    <label for="status-filter">Filter by Status:</label>
                    <select id="status-filter">
                        <option value="all">All Statuses</option>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                    <a href="newTicket.html" class="new-ticket-button">Create new ticket</a>
                </div>
                <div class="ticket" data-department="accounting" data-status="open">
                    <h3 class="ticket-subject">Invoice Issue</h3>
                    <div class="ticket-info">
                        <span class="ticket-id">ID: 1</span>
                        <span class="ticket-department">Department: Accounting</span>
                        <span class="ticket-status">Status: Open</span>
                    </div>
                    <p class="ticket-summary">Need help with my invoice that is showing incorrect amounts.</p>
                </div>
                <div class="ticket" data-department="support" data-status="closed">
                    <h3 class="ticket-subject">Cannot Access Account</h3>
                    <div class="ticket-info">
                        <span class="ticket-id">ID: 2</span>
                        <span class="ticket-department">Department: Support</span>
                        <span class="ticket-status">Status: Closed</span>
                    </div>
                    <p class="ticket-summary">I cannot access my account with the login credentials I have, it says invalid.</p>
                </div>
                <div class="ticket" data-department="accounting" data-status="open">
                    <h3 class="ticket-subject">Payment Confirmation</h3>
                    <div class="ticket-info">
                        <span class="ticket-id">ID: 3</span>
                        <span class="ticket-department">Department: Accounting</span>
                        <span class="ticket-status">Status: Open</span>
                    </div>
                    <p class="ticket-summary">I made a payment and need confirmation that it was received and processed.</p>
                </div>
            </section>
        </main>
        <?php include 'templates/footer.tpl.php';?>
    </body>
</html>