<?php

    declare(strict_types=1);

    class Inquiries {
        public ?int $id;
        public int $ticketId;
        public string $userRole;
        public int $userId;
        public string $message;
        public $createdAt;

        public function __construct(?int $id, int $ticketId, string $userRole, int $userId, string $message) {
            $this->id = $id;
            $this->ticketId = $ticketId;
            $this->userRole = $userRole;
            $this->userId = $userId;
            $this->message = $message;
            $this->createdAt = date('Y-m-d H:i:s');
        }

    }

    function createInquiry(PDO $db, int $ticketId, string $userRole, int $userId, string $message): bool {
        $createdAt = date('Y-m-d H:i:s');
        $stmt = $db->prepare('
            INSERT INTO inquiries (ticket_id, user_role, user_id, message, created_at)
            VALUES (?, ?, ?, ?, ?)
        ');
        
        return $stmt->execute(array($ticketId, $userRole, $userId, $message, $createdAt));
    }

    function getInquiries(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM inquiries');
        $stmt->execute();

        $inquiries = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $inquiries[] = $row;
        }

        return $inquiries;
    }

?>
