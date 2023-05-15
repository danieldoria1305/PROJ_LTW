<?php

declare(strict_types=1);

class User {
    private ?int $id;
    private string $username;
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

    public static function createUser(PDO $db, array $data): User {
        $stmt = $db->prepare('
            INSERT INTO User (name, username, password, email, role)
            VALUES (?, ?, ?, ?, ?)
        ');

        $stmt->execute([$data['name'], $data['username'], password_hash($data['password'], PASSWORD_DEFAULT), $data['email'], $data['role']]);
        
        $id = (int) $db->lastInsertId();

        return new User(
            $id,
            $data['username'],
            $data['password'],
            $data['email'],
            $data['name'],
            $data['role']
        );
    }

    public static function getUserWithPassword(PDO $db, string $username): ?User {
        $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');

        $stmt->execute([$username]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($row['password'], PASSWORD_DEFAULT)) {
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


        /*
    function createUser(PDO $db, $username, $password, $name, $email) {
        try {
            $stmt = $db->prepare('INSERT INTO User(username, password, email, name) VALUES (:Username,:Password,:Email,:Name)');
            $stmt->bindParam(':Username', $username);
            $stmt->bindParam(':Password', $passwordhashed);
            $stmt->bindParam(':Name', $name);
            $stmt->bindParam(':Email', $email);
            if($stmt->execute()){
                $id = getID($username);
                return $id;
            }
            else return -1;
        } catch(PDOException $e) return -1;
    
    }*/
    
    function createUser(PDO $db, $username, $password, $name, $email) {
        $stmt = $db->prepare('
            INSERT INTO users (Name, Username, Password, Email)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute(array($name, $username, sha1($password), $email));
        return (int)$db->lastInsertId();
    }

    function duplicateUsername(PDO $db, $username) {
        try {
            $stmt = $db->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->execute(array($username));
            return $stmt->fetch()  !== false;
        
        }catch(PDOException $e) {
            return true;
        }
    }

    function duplicateEmail(PDO $db, $email) {
        try {
            $stmt = $db->prepare('SELECT ID FROM users WHERE email = ?');
            $stmt->execute(array($email));
            return $stmt->fetch()  !== false;
        
        }catch(PDOException $e) {
            return true;
        }
    }

