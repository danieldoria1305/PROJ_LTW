<?php

    declare(strict_types=1);

    class Hashtags {
        public ?int $id;
        public string $name;

        public function __construct(?int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }

    }

    
    function createHashtag(PDO $db, $name) {
        $stmt = $db->prepare('
            SELECT id
            FROM hashtags
            WHERE name = ?
        ');

        $stmt->execute(array($name));
        $existingHashtag = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingHashtag) {
            $stmt = $db->prepare('
                INSERT INTO hashtags (name)
                VALUES (?)
            ');

            $stmt->execute(array($name));
            return (int)$db->lastInsertId();
        }
        return (int)$existingHashtag['id'];
    }

    function getHashtags(PDO $db) {
        $stmt = $db->prepare('SELECT * FROM hashtags');
        $stmt->execute();

        $hashtags = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $hashtags[] = new Hashtags(
                (int) $row['id'],
                $row['name']
            );
        }

        return $hashtags;
    }
    
    function getHashtagsNameById(PDO $db, int $id): string {
        $stmt = $db->prepare('SELECT name FROM hashtags WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['name'];
        }

        return '';
    }

?>
