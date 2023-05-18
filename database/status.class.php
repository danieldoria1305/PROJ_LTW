<?php

    declare(strict_types=1);

    class Status {
        public ?int $id;
        public string $name;

        public function __construct(?int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }

    }

    function createStatus(PDO $db, $name) {
        $stmt = $db->prepare('
            INSERT INTO status (Name)
            VALUES (?)
        ');

        $stmt->execute(array($name));
        return (int)$db->lastInsertId();
    }

    function getStatus(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM status');
        $stmt->execute();

        $status = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $status[] = new Status(
                (int) $row['id'],
                $row['name']
            );
        }

        return $status;
    }

    function getStatusNameById(PDO $db, int $id): string {
        $stmt = $db->prepare('SELECT name FROM status WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['name'];
        }

        return '';
    }

?>
