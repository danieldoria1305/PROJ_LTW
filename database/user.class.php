<?php

    declare(strict_types=1);

    class User {
        public ?int $id;
        public string $username;
        public string $password;
        public string $email;
        public string $name;
        public string $role;
        public int $departmentId;

        public function __construct(?int $id, string $username, string $password, string $email, string $name, string $role, int $departmentId = 1) {
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->name = $name;
            $this->role = $role;
            $this->departmentId = $departmentId;
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

    function getUserById(PDO $db, int $id): ?User {
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);

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

    function updateUser(PDO $db, int $id, string $username, string $password, string $name, string $email): bool {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('
            UPDATE users
            SET username = ?, password = ?, email = ?, name = ?
            WHERE id = ?
        ');

        return $stmt->execute(array($username, $password_hash, $email, $name, $id));
    }

    function updateUserRole(PDO $db, int $id, string $role): bool {
        $stmt = $db->prepare('
            UPDATE users
            SET role = ?
            WHERE id = ?
        ');

        return $stmt->execute(array($role, $id));
    }

    function getUserData(PDO $db, int $userId): ?User {
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$userId]);

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

    function getClients(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM users WHERE role = ?');
        $stmt->execute(['client']);

        $clients = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = new User(
                (int) $row['id'],
                $row['username'],
                $row['password'],
                $row['email'],
                $row['name'],
                $row['role']
            );
        }

        return $clients;
    }

    function getAgents(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM users WHERE role = ?');
        $stmt->execute(['agent']);

        $agents = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $agents[] = new User(
                (int) $row['id'],
                $row['username'],
                $row['password'],
                $row['email'],
                $row['name'],
                $row['role'],
                (int) $row['department_id']
            );
        }

        return $agents;
    }

    function updateUserDepartment(PDO $db, int $id, int $departmentId): bool {
        $stmt = $db->prepare('
            UPDATE users
            SET department_id = ?
            WHERE id = ?
        ');

        return $stmt->execute([$departmentId, $id]);
    }

    function deleteUser(PDO $db, ?int $userId): bool {
        $stmt = $db->prepare('DELETE FROM users WHERE id = :userId');
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

?>
