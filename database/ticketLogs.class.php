<?php

    declare(strict_types=1);


    class TicketLogs {
        public ?int $id;
        public int $ticketId;
        public string $fieldName;
        public string $oldValue;
        public string $newValue;
        public $createdAt;

        public function __construct(?int $id, int $ticketId, string $fieldName, string $oldValue, string $newValue) {
            $this->id = $id;
            $this->ticketId = $ticketId;
            $this->fieldName = $fieldName;
            $this->oldValue = $oldValue;
            $this->newValue = $newValue;
            $this->createdAt = date('Y-m-d H:i:s');
        }

        public function createLog(PDO $db, int $ticketId, string $fieldName, string $oldValue, string $newValue): bool {
            $stmt = $db->prepare('
                INSERT INTO ticket_logs (ticket_id, field, old_value, new_value, created_at)
                VALUES (?, ?, ?, ?, ?)
            ');

            $stmt->execute([$ticketId, $fieldName, $oldValue, $newValue, date('Y-m-d H:i:s')]);
            return (bool) $stmt->rowCount();
        }


        public function saveLog($db) {
            $stmt = $db->prepare("INSERT INTO ticket_logs (ticket_id, field, old_value, new_value, created_at) VALUES (?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $this->ticketId, PDO::PARAM_INT);
            $stmt->bindValue(2, $this->fieldName, PDO::PARAM_STR);
            $stmt->bindValue(3, $this->oldValue, PDO::PARAM_STR);
            $stmt->bindValue(4, $this->newValue, PDO::PARAM_STR);
            $stmt->bindValue(5, date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    function getLogsByTicketId(PDO $db, int $ticketId): array {
        $stmt = $db->prepare('SELECT * FROM ticket_logs WHERE ticket_id = :ticketId');
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();

        $logs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $logs[] = new TicketLogs(
                (int) $row['id'],
                (int) $row['ticket_id'],
                $row['field'],
                $row['old_value'],
                $row['new_value']
            );
        }

        return $logs;
    }
?>
