<?php

    require_once '../database/connection.db.php';
    require_once '../database/hashtags.class.php';

    $db = getDatabaseConnection();

    if (isset($_GET['input'])) {
        $input = $_GET['input'];
        $suggestions = fetchHashtagSuggestions($db, $input);
        echo json_encode($suggestions);
    }

    function fetchHashtagSuggestions($db, $input) {
        $input = '%' . $input . '%';
        $query = 'SELECT name FROM hashtags WHERE name LIKE :input';
        $statement = $db->prepare($query);
        $statement->bindValue(':input', $input);
        $statement->execute();
        $suggestions = $statement->fetchAll(PDO::FETCH_COLUMN);
        return $suggestions;
    }

?>