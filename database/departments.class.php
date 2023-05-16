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
                INSERT INTO department (Name)
                VALUES (?)
            ');

            $stmt->execute(array($name));
            return (int)$db->lastInsertId();
        }

    }

?>
