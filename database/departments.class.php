<?php

    declare(strict_types=1);

    class Departments {
        public ?int $id;
        public string $name;

        public function __construct(?int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }

        public function createDepartment(PDO $db, $name) {
            $stmt = $db->prepare('
                INSERT INTO departments (Name)
                VALUES (?)
            ');

            $stmt->execute(array($name));
            return (int)$db->lastInsertId();
        }

    }

    function getDepartments(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM departments');
        $stmt->execute();

        $departments = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $departments[] = new Departments(
                (int) $row['id'],
                $row['name']
            );
        }

        return $departments;
    }

    function getDepartmentsNameById(PDO $db, int $id): string {
        $stmt = $db->prepare('SELECT name FROM departments WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['name'];
        }

        return '';
    }

?>
