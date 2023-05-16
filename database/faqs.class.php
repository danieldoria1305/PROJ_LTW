<?php

    declare(strict_types=1);

    class Faqs {
        public ?int $id;
        public string $question;
        public string $answer;

        public function __construct(?int $id, string $question, string $answer) {
            $this->id = $id;
            $this->question = $question;
            $this->answer = $answer;
        }

        public function createFaq(PDO $db, $question, $answer) {
            $stmt = $db->prepare('
                INSERT INTO department (Question, Answer)
                VALUES (?, ?)
            ');

            $stmt->execute(array($question, $answer));
            return (int)$db->lastInsertId();
        }

    }

?>
