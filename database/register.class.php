<?php

declare(strict_types=1);

require_once('connection.php');

class Register{

    private $db;
    private $name;
    private $username;
    private $email;
    private $password;
    private $role;

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getRole() {
        return $this->role;
    }

    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function createUser(array $userData): bool{
        $sql = "INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        $name = $userData['name'];
        $username = $userData['username'];
        $email = $userData['email'];
        $password = $userData['password'];
        $role = $userData['user-type'];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([$name, $username, $email, $hashedPassword, $role]);
    }

    public function registerUser(string $name, string $username, string $email, string $password, string $userType): void{
        $stmt = $this->db->prepare("INSERT INTO users (name, username, email, password, user_type) VALUES (:name, :username, :email, :password, :user_type)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_type', $userType);
        $stmt->execute();
    }

    public function printUsers(){
        // execute the query and fetch the results
        $stmt = $this->db->query("SELECT * FROM users");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // print the results
        foreach ($results as $row) {
            echo "{$row['name']} ({$row['email']})<br>";
        }
    }
}
