<?php

    declare(strict_types=1);

    class User {
        public ?int $id;
        public string $username;
        private string $password;
        private string $email;
        private string $name;
        private string $role;

        public function __construct(?int $id, string $username, string $password, string $email, string $name, string $role) {
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->name = $name;
            $this->role = $role;
        }

        public function getId(): ?int {
            return $this->id;
        }

        public function getUsername(): string {
            return $this->username;
        }

        public function getPassword(): string {
            return $this->password;
        }

        public function getEmail(): string {
            return $this->email;
        }

        public function getName(): string {
            return $this->name;
        }

        public function getRole(): string {
            return $this->role;
        }

        public function save(PDO $db) {
            if ($this->id) {
                $stmt = $db->prepare('
                    UPDATE User SET name = ?, username = ?, password = ?, email = ?, role = ?
                    WHERE id = ?
                ');

                $stmt->execute([$this->name, $this->username, $this->password, $this->email, $this->role, $this->id]);
            } else {
                $stmt = $db->prepare('
                    INSERT INTO User (name, username, password, email, role)
                    VALUES (?, ?, ?, ?, ?)
                ');

                $stmt->execute([$this->name, $this->username, $this->password, $this->email, $this->role]);

                $this->id = (int) $db->lastInsertId();
            }
        }

        public function createUser(PDO $db, $username, $password, $name, $email) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare('
                INSERT INTO users (Name, Username, Password, Email)
                VALUES (?, ?, ?, ?)
            ');

            $stmt->execute(array($name, $username, $password_hash, $email));
            return (int)$db->lastInsertId();
        }

        public function duplicateUsername(PDO $db, $username) {
            try {
                $stmt = $db->prepare('SELECT id FROM users WHERE username = ?');
                $stmt->execute(array($username));
                return $stmt->fetch()  !== false;
            
            }catch(PDOException $e) {
                return true;
            }
        }

        public function duplicateEmail(PDO $db, $email) {
            try {
                $stmt = $db->prepare('SELECT ID FROM users WHERE email = ?');
                $stmt->execute(array($email));
                return $stmt->fetch()  !== false;
            
            }catch(PDOException $e) {
                return true;
            }
        }

        public static function getUserByEmail(PDO $db, string $email): ?User {
            $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new User(
                    (int) $row['id'],
                    $row['username'],
                    $row['password'],
                    $row['email'],
                    $row['name'],
                    $row['role']
                );
            }
            return null;
        }

        public static function getUserByUsername(PDO $db, string $username): ?User {
            $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->execute([$username]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new User(
                    (int) $row['id'],
                    $row['username'],
                    $row['password'],
                    $row['email'],
                    $row['name'],
                    $row['role']
                );
            }
            return null;
        }

        public static function getUserWithPassword(PDO $db, string $username, string $password): ?User {
            $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');

            $stmt->execute([$username]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($password, $row['password'])) {
                return new User(
                    (int) $row['id'],
                    $row['username'],
                    $row['password'],
                    $row['email'],
                    $row['name'],
                    $row['role']
                );
            }

            return null;
        }

    }

?>
