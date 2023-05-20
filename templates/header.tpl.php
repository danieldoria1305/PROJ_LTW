<!DOCTYPE html>
<html>

    <link rel="stylesheet" href="../style/header.css">

    <header>
        <h1>Ticketly <span class="smaller">Tickets Area</span></h1>
        <nav>
            <ul>
                <li><a href="myPage.php">My Profile</a></li>
                <?php if ($_SESSION['role'] != 'client') { ?>
                    <li><a href="listClients.php">Clients' List</a></li>
                    <li><a href="listAgents.php">Agents' List</a></li>
                <?php } ?>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="../actions/action_logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>

</html>