<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Ticketly - My Page</title>
    <link rel="stylesheet" href="style/myPage.css">
    <link rel="stylesheet" href="style/header.css">
  </head>
  <body>
    <header>
      <h1>Ticketly <span class="smaller">My Page</span></h1>
      <nav>
        <ul>
          <li><a href="client.php">Back to My Tickets</a></li>
          <li><a href="index.php">Log out</a></li>
        </ul>
      </nav>
    </header>

    <main>
        <section id="edit-profile">
          <h2>Edit Profile</h2>
          <form id="edit-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Save Changes">
          </form>
        </section>
      </main>
      
      <?php include 'templates/footer.tpl.php';?>
      
    </body>
</html>      