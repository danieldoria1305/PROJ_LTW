<?php

    declare(strict_types=1);


    class TicketHashtags {
        public int $ticketId;
        public int $hashtagId;

        public function __construct(int $ticketId, int $hashtagId) {
            $this->ticketId = $ticketId;
            $this->hashtagId = $hashtagId;
        }
    }

    function createTicketHashtag(PDO $db, int $ticketId, int $hashtagId): bool {
        $stmt = $db->prepare('
            INSERT INTO ticket_hashtags (ticket_id, hashtag_id)
            VALUES (?, ?)
        ');

        $stmt->execute([$ticketId, $hashtagId]);
        return (bool) $stmt->rowCount();
    }

    function deleteTicketHashtags(PDO $db, int $ticketId): bool {
        $stmt = $db->prepare('DELETE FROM ticket_hashtags WHERE ticket_id = ?');
        $stmt->execute([$ticketId]);
    return (bool)$stmt->rowCount();
}

    function getTicketHashtags(PDO $db, int $ticketId): array {
        $stmt = $db->prepare('SELECT * FROM ticket_hashtags WHERE ticket_id = :ticketId');
        $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();

        $ticketHashtags = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ticketHashtags[] = new TicketHashtags(
                (int) $row['ticket_id'],
                (int) $row['hashtag_id']
            );
        }

        return $ticketHashtags;
    }

?>
