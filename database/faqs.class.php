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

    }

    function createFaq(PDO $db, $question, $answer) {
        $stmt = $db->prepare('
            INSERT INTO faqs (Question, Answer)
            VALUES (?, ?)
        ');

        $stmt->execute(array($question, $answer));
        return (int)$db->lastInsertId();
    }

    function getFaqData(PDO $db) {
        $stmt = $db->query('SELECT * FROM faqs');
        $faqs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = isset($row['id']) ? (int)$row['id'] : null;
            $question = isset($row['question']) ? $row['question'] : '';
            $answer = isset($row['answer']) ? $row['answer'] : '';
            $faq = new Faqs($id, $question, $answer);
            $faqs[] = $faq;
        }
        return $faqs;
    }

    function getFaqEditData(PDO $db, ?int $faqId): ?Faqs {
        $stmt = $db->prepare('SELECT * FROM faqs WHERE id = :faqId');
        $stmt->bindValue(':faqId', $faqId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row === false) {
            return null;
        }
        
        $id = isset($row['id']) ? (int) $row['id'] : null;
        $question = isset($row['question']) ? $row['question'] : '';
        $answer = isset($row['answer']) ? $row['answer'] : '';
        return new Faqs($id, $question, $answer);
    }

    function editFaq(PDO $db, ?int $faqId, string $question, string $answer): bool {
        $stmt = $db->prepare('UPDATE faqs SET question = :question, answer = :answer WHERE id = :faqId');
        $stmt->bindValue(':question', $question, PDO::PARAM_STR);
        $stmt->bindValue(':answer', $answer, PDO::PARAM_STR);
        $stmt->bindValue(':faqId', $faqId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    function deleteFaq(PDO $db, ?int $faqId): bool {
        $stmt = $db->prepare('DELETE FROM faqs WHERE id = :faqId');
        $stmt->bindValue(':faqId', $faqId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    function getFaqDataById(PDO $db, ?int $faqId): ?Faqs {
        $stmt = $db->prepare('SELECT * FROM faqs WHERE id = :faqId');
        $stmt->bindValue(':faqId', $faqId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        $id = isset($row['id']) ? (int) $row['id'] : null;
        $question = isset($row['question']) ? $row['question'] : '';
        $answer = isset($row['answer']) ? $row['answer'] : '';
        return new Faqs($id, $question, $answer);
}

?>
