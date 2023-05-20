<!DOCTYPE html>
<html>

    <link rel="stylesheet" href="../style/header.css">

    <header>
        
        <h1>Ticketly <?php 
            if (strpos($_SERVER['PHP_SELF'], 'assignTicket.php') !== false) echo '<span class="smaller">Assign Agent</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'editFaq.php') !== false) echo '<span class="smaller">Edit FAQ</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'editTicket.php') !== false) echo '<span class="smaller">Edit Ticket</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'faq.php') !== false) echo '<span class="smaller">FAQ</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'inquiries.php') !== false) echo '<span class="smaller">Inquiries</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'listAgents.php') !== false) echo '<span class="smaller">Agents\' List</span>'; 
            elseif (strpos($_SERVER['PHP_SELF'], 'listClients.php') !== false) echo '<span class="smaller">Clients\' List</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'login.php') !== false) echo '<span class="smaller">Login</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'myPage.php') !== false) echo '<span class="smaller">Edit Profile</span>'; 
            elseif (strpos($_SERVER['PHP_SELF'], 'newFaq.php') !== false) echo '<span class="smaller">New FAQ</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'newTicket.php') !== false) echo '<span class="smaller">Create Ticket</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'register.php') !== false) echo '<span class="smaller">Register</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'ticketLog.php') !== false) echo '<span class="smaller">Ticket Log</span>';
            elseif (strpos($_SERVER['PHP_SELF'], 'tickets.php') !== false) echo '<span class="smaller">Tickets</span>'; 
        ?></h1>
        <nav>
            <ul>
                <?php
                if (strpos($_SERVER['PHP_SELF'], 'tickets.php') === false) 
                    echo '<li><a href="tickets.php">Tickets</a></li>';
                ?> 
                
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <?php
                    if (strpos($_SERVER['PHP_SELF'], 'listClients.php') === false) 
                        echo '<li><a href="listClients.php">Clients\' List</a></li>';
                    ?> 
                    <?php
                    if (strpos($_SERVER['PHP_SELF'], 'listAgents.php') === false) 
                        echo '<li><a href="listAgents.php">Agents\' List</a></li>';
                    ?> 
                <?php } ?>

                <?php
                if (strpos($_SERVER['PHP_SELF'], 'faq.php') === false) 
                    echo '<li><a href="faq.php">FAQ</a></li>';
                ?> 

                <?php
                if (strpos($_SERVER['PHP_SELF'], 'myPage.php') === false) 
                    echo '<li><a href="myPage.php">My Profile</a></li>';
                ?> 

                <li><a href="../actions/action_logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>

</html>