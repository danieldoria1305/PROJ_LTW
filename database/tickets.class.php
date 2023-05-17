<?php  

    declare(strict_types=1);

    require_once __DIR__ . '/../database/hashtags.class.php';
    require_once __DIR__ . '/../database/faqs.class.php';

    class Tickets {
        public int $id;
        public string $title;
        public string $description;
        private int $clientId;
        private int $agentId;
        private int $statusId;
        private string $priority;
        private $createdAt;
        private $updatedAt;
        public int $departmentId;

        public function __construct(?int $id, string $title, string $description, int $clientId, int $agentId, int $statusId = 1, string $priority = 'medium', ?int $departmentId) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->clientId = $clientId;
            $this->agentId = $agentId;
            $this->statusId = $statusId;
            $this->priority = $priority;
            $this->createdAt = date('Y-m-d H:i:s');
            $this->updatedAt = $this->createdAt;
            $this->departmentId = $departmentId;
        }

        public function getTicketHashtags() {
            $db = getDatabaseConnection();

            $stmt = $db->prepare('SELECT hashtags.id, hashtags.name FROM hashtags INNER JOIN ticket_hashtags ON hashtags.id = ticket_hashtags.hashtag_id WHERE ticket_hashtags.ticket_id = ?');
            $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
            $stmt->execute();

            $hashtags = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $hashtags[] = $row;
            }

            return $hashtags;
        }


        public function getTicketFAQs() {
            $db = getDatabaseConnection();

            $stmt = $db->prepare('SELECT faqs.id, faqs.question, faqs.answer FROM faqs INNER JOIN ticket_faqs ON faqs.id = ticket_faqs.faq_id WHERE ticket_faqs.ticket_id = ?');
            $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
            $stmt->execute();

            $faqs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $faqs[] = $row;
            }

            return $faqs;
        }

    }

    function createTicket(PDO $db, $title, $description, $clientId, $departmentId = null, $priority = 'medium') {
        $createdAt = date('Y-m-d H:i:s');
        $updatedAt = $createdAt;
        $stmt = $db->prepare('
            INSERT INTO tickets (title, description, client_id, department_id, priority, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        $stmt->execute(array($title, $description, $clientId, $departmentId, $priority, $createdAt, $updatedAt));
        return (int)$db->lastInsertId();
    }

    function deleteTicket(PDO $db, $ticketId) {
        $stmt = $db->prepare('
            DELETE FROM tickets WHERE id = ?
        ');
        $stmt->execute(array($ticketId));
    }
?>

