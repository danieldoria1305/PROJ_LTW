<?php

    declare(strict_types=1);

    class User {
        public ?int $id;
        public string $username;
        public string $password;
        public string $email;
        public string $name;
        public string $role;

        public function __construct(?int $id, string $username, string $password, string $email, string $name, string $role) {
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->name = $name;
            $this->role = $role;
        }

    }

    function createUser(PDO $db, $username, $password, $name, $email) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('
            INSERT INTO users (Name, Username, Password, Email)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute(array($name, $username, $password_hash, $email));
        return (int)$db->lastInsertId();
    }

    function duplicateUsername(PDO $db, $username) {
        try {
            $stmt = $db->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->execute(array($username));
            return $stmt->fetch()  !== false;
        
        } catch(PDOException $e) {
            return true;
        }
    }

    function duplicateEmail(PDO $db, $email) {
        try {
            $stmt = $db->prepare('SELECT ID FROM users WHERE email = ?');
            $stmt->execute(array($email));
            return $stmt->fetch()  !== false;
        
        } catch(PDOException $e) {
            return true;
        }
    }

    function getUserByEmail(PDO $db, string $email): ?User {
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

    function getUserByUsername(PDO $db, string $username): ?User {
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

    function getUserWithPassword(PDO $db, string $username, string $password): ?User {
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

?>
