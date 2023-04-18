<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketly</title>
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/header.css">
</head>
<body>
    <header>
        <h1>Ticketly</h1>
        <nav>
            <ul>
                <li><a href="#">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="hero">
            <h2>Welcome to Ticketly</h2>
            <p>Submit a ticket to report an issue, track its progress and resolve it efficiently.</p>
        </section>
        <section id="faq">
            <h3>Frequently Asked Questions</h3>
            <ul>
                <li>
                    <h4>How do I submit a ticket?</h4>
                    <p>To submit a ticket, click on the "Submit a Ticket" button on the homepage, fill out the form, and click "Submit".</p>
                </li>
                <li>
                    <h4>How do I track the progress of my ticket?</h4>
                    <p>To track the progress of your ticket, log in to your account, go to the "View Tickets" page, and click on the ticket you want to view.</p>
                </li>
                <li>
                    <h4>How do I communicate with support staff?</h4>
                    <p>You can communicate with support staff by replying to the email notifications you receive when your ticket is updated.</p>
                </li>
                <li>
                    <h4>How do I resolve a ticket?</h4>
                    <p>To resolve a ticket, log in to your account, go to the "View Tickets" page, and click on the ticket you want to resolve. Then, click on the "Resolve" button and follow the instructions.</p>
                </li>
            </ul>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php';?>
</body>
</html>
