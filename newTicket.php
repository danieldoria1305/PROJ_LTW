<html>
    <head>
        <meta charset="utf-8">
        <title>Ticketly - New Ticket</title>
        <link rel="stylesheet" href="style/newTicket.css">
        <link rel="stylesheet" href="style/header.css">
    </head>
    <body>
        <header>
            <h1>Ticketly <span class="smaller">New Ticket</span></h1>
            <nav>
                <ul>
                    <li><a href="client.php">Back to My Tickets</a></li>
                    <li><a href="index.php">Log out</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <h2>New Ticket</h2>
            <form action="submitTicket.php" method="post">
                <div>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-row">
                    <label for="department">Department:</label>
                    <select id="department" name="department_id">
                        <option value="1">Accounting</option>
                        <option value="2">Support</option>
                        <option value="3">I'm not sure</option>
                    </select>
                    <label for="priority">Priority:</label>
                    <select id="priority" name="priority">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <button type="submit">Submit</button>
            </form>
        </main>
        <?php include 'templates/footer.tpl.php';?>
    </body>
</html>
