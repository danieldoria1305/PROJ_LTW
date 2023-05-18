<?php
    function redirectBasedOnRole(string $role){
        switch ($role) {
            case 'client':
                header('Location: ../pages/client.php');
                break;
            case 'agent':
                header('Location: ../pages/agent.php');
                break;
            case 'admin':
                header('Location: ../pages/admin.php');
                break;
            default:
                header('Location: ../pages/index.php');
                break;
        }
        exit();
    }
?>