<?php
    class Session {

        private array $messages;

        public function __construct() {
            session_start();
            $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
            unset($_SESSION['messages']);
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['id']);    
        }

        public function logout() {
            session_destroy();
        }

        public function getId() : ?int {
            return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
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
            
        public function setId(int $id) {
            $_SESSION['id'] = $id;
        }

        public function setName(string $name) {
            $_SESSION['name'] = $name;
        }

        public function setRole(string $role) {
            $_SESSION['role'] = $role;
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
    }
?>