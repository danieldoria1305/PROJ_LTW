<?php  

    declare(strict_types=1);

    require_once __DIR__ . '/../database/hashtags.class.php';
    require_once __DIR__ . '/../database/faqs.class.php';

    class Tickets {
        public int $id;
        public string $title;
        public string $description;
        public ?string $answer;
        public int $clientId;
        public ?int $agentId;
        public int $statusId;
        public string $priority;
        public $createdAt;
        public $updatedAt;
        public ?int $departmentId;

        public function __construct(?int $id, string $title, string $description, ?string $answer, int $clientId, ?int $agentId, int $statusId = 1, string $priority = 'medium', ?int $departmentId) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->answer = $answer;
            $this->clientId = $clientId;
            $this->agentId = $agentId;
            $this->statusId = $statusId;
            $this->priority = $priority;
            $this->createdAt = date('Y-m-d H:i:s');
            $this->updatedAt = $this->createdAt;
            $this->departmentId = $departmentId;
        }
    }

    function createTicket(PDO $db, $title, $description, $clientId, $departmentId = null) {
        $createdAt = date('Y-m-d H:i:s');
        $updatedAt = $createdAt;
        $stmt = $db->prepare('
            INSERT INTO tickets (title, description, client_id, department_id, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        $stmt->execute(array($title, $description, $clientId, $departmentId, $createdAt, $updatedAt));
        return (int)$db->lastInsertId();
    }

    function getTicketEditData(PDO $db, ?int $ticketId): ?Tickets {
        $stmt = $db->prepare('SELECT * FROM tickets WHERE id = :ticketId');
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row === false) {
            return null;
        }
        
        $id = isset($row['id']) ? (int) $row['id'] : null;
        $title = isset($row['title']) ? $row['title'] : null;
        $description = isset($row['description']) ? $row['description'] : null;
        $answer = isset($row['answer']) ? $row['answer'] : null;
        $clientId = isset($row['client_id']) ? (int) $row['client_id'] : null;
        $agentId = isset($row['agent_id']) ? (int) $row['agent_id'] : null;
        $statusId = isset($row['status_id']) ? (int) $row['status_id'] : null;
        $priority = isset($row['priority']) ? $row['priority'] : null;
        $departmentId = isset($row['department_id']) ? (int) $row['department_id'] : null;

        return new Tickets($id, $title, $description, $answer, $clientId, $agentId, $statusId, $priority, $departmentId);
    }

    function updateTicket(PDO $db, int $ticketId, string $title, string $description, ?string $answer, int $clientId, ?int $agentId, int $statusId, string $priority, ?int $departmentId): bool {
        $updatedAt = date('Y-m-d H:i:s');
        $stmt = $db->prepare('
            UPDATE tickets
            SET title = :title, description = :description, answer = :answer, client_id = :clientId, agent_id = :agentId, status_id = :statusId, priority = :priority, department_id = :departmentId, updated_at = :updatedAt
            WHERE id = :ticketId
        ');

        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':answer', $answer, PDO::PARAM_STR);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        $stmt->bindValue(':agentId', $agentId, PDO::PARAM_INT);
        $stmt->bindValue(':statusId', $statusId, PDO::PARAM_INT);
        $stmt->bindValue(':priority', $priority, PDO::PARAM_STR);
        $stmt->bindValue(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindValue(':updatedAt', $updatedAt, PDO::PARAM_STR);
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    function getTicketById(PDO $db, int $ticketId): ?Tickets{
        $stmt = $db->prepare('SELECT * FROM tickets WHERE id = :ticketId');
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        $id = isset($row['id']) ? (int) $row['id'] : null;
        $title = isset($row['title']) ? $row['title'] : null;
        $description = isset($row['description']) ? $row['description'] : null;
        $answer = isset($row['answer']) ? $row['answer'] : null;
        $clientId = isset($row['client_id']) ? (int) $row['client_id'] : null;
        $agentId = isset($row['agent_id']) ? (int) $row['agent_id'] : null;
        $statusId = isset($row['status_id']) ? (int) $row['status_id'] : null;
        $priority = isset($row['priority']) ? $row['priority'] : null;
        $departmentId = isset($row['department_id']) ? (int) $row['department_id'] : null;

        return new Tickets($id, $title, $description, $answer, $clientId, $agentId, $statusId, $priority, $departmentId);
    }

    function updateTicketAgent(PDO $db, int $ticketId, int $agentId): bool {
        $updatedAt = date('Y-m-d H:i:s');
        $statusId = $agentId !== null ? 2 : 1;

        $stmt = $db->prepare('
            UPDATE tickets
            SET agent_id = :agentId, status_id = :statusId, updated_at = :updatedAt
            WHERE id = :ticketId
        ');

        $stmt->bindValue(':agentId', $agentId, PDO::PARAM_INT);
        $stmt->bindValue(':statusId', $statusId, PDO::PARAM_INT);
        $stmt->bindValue(':updatedAt', $updatedAt, PDO::PARAM_STR);
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);

        return $stmt->execute();
    }
    
    function deleteTicket(PDO $db, ?int $ticketId): bool {
        $stmt = $db->prepare('DELETE FROM tickets WHERE id = :ticketId');
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    function deleteUserTickets(PDO $db, ?int $userId): bool {
        $stmt = $db->prepare('DELETE FROM tickets WHERE client_id = :userId');
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    function unassignTickets(PDO $db, ?int $agentId): bool {
        $stmt = $db->prepare('UPDATE tickets SET agent_id = NULL, status_id = 1 WHERE agent_id = :agentId');
        $stmt->bindValue(':agentId', $agentId, PDO::PARAM_INT);
        return $stmt->execute();
    }
?>

