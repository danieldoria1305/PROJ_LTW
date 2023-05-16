<?php

    declare(strict_types=1);

    class Hashtags {
        public ?int $id;
        public string $name;

        public function __construct(?int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }

        public function createHashtag(PDO $db, $name) {
            $stmt = $db->prepare('
                INSERT INTO department (Name)
                VALUES (?)
            ');

            $stmt->execute(array($name));
            return (int)$db->lastInsertId();
        }

    }

?>
