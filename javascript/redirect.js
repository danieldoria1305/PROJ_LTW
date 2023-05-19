function redirectToTickets(role) {
    switch (role) {
        case "client":
            window.location.href = "../pages/client.php";
            break;
        case "agent":
            window.location.href = "../pages/agent.php";
            break;
        case "admin":
            window.location.href = "../pages/admin.php";
            break;
        default:
            window.location.href = "../pages/index.php";
            break;
    }
}
