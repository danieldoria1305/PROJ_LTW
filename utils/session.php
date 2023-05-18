<?php class Session {

    public array $messages;
    public ?string $username;
    public string $role = '';

    public function __construct() {
        session_start();
        $this->messages = $_SESSION['messages'] ?? array();
        unset($_SESSION['messages']);

        $this->username = $_SESSION['username'] ?? null;
        $this->role = $_SESSION['role'] ?? '';
    }

    public function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getId() : ?int {
        return $_SESSION['userID'] ?? null;
    }

    public function setId(int $id) {
        $_SESSION['userID'] = $id;
    }

    public function setUsername(string $username) {
        $_SESSION['username'] = $username;
        $this->username = $username;
    }

    public function setRole(string $role) {
        $_SESSION['role'] = $role;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function hasUsername(): bool {
        return isset($this->username);
    }

    public function isLoggedIn() : bool {
        return isset($_SESSION['userID']);    
    }

    public function logout() {
        session_destroy();
    }

    public function getName() : ?string {
        return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function isClient() : bool {
        return isset($_SESSION['role']) ? 
            strcmp($_SESSION['role'], "client") === 0 : 
            false;
    }

    public function isAgent() : bool {
        return isset($_SESSION['role']) ? 
            strcmp($_SESSION['role'], "agent") === 0 : 
            false;
    }

    public function isAdmin() : bool {
        return isset($_SESSION['role']) ? 
            strcmp($_SESSION['role'], "admin") === 0 : 
            false;
    }

    public function setName(string $name) {
        $_SESSION['name'] = $name;
    }

    public function addMessage(string $type, string $text) {
        $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
        return $this->messages;
    }



    /*
    function setCurrentUser($userID, $username) {
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = $userID;
    }

    function getUserID() {
        if(isset($_SESSION['userID'])) {
            return $_SESSION['userID'];
        } else {
        return null;
        }
    }

    function getUsername() {
        if(isset($_SESSION['username'])) {
            return $_SESSION['username'];
        } else {
            return null;
        }
    }
    */
} ?>