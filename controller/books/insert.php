<?php

require_once __DIR__ . '/../../conf/connection.php';
require_once __DIR__ . '/../auth/middleware.php';
checkLogin();

function insertBook(PDO $pdo, $bookName) {
    session_start();

    if (empty($bookName)) {
        return false;
    }

    if (!isset($_SESSION["user_id"])) {
        return false;
    }

    $userId = $_SESSION["user_id"];

    try {
        $insertBookQuery = "INSERT INTO books (name, user_id) VALUES (?, ?)";
        $insertBookStmt = $pdo->prepare($insertBookQuery);

        $insertBookStmt->bindParam(1, $bookName, PDO::PARAM_STR);
        $insertBookStmt->bindParam(2, $userId, PDO::PARAM_INT);

        $insertBookStmt->execute();

        return true;
    } catch (PDOException $e) {
        die("Error inserting book: " . $e->getMessage());
    }
}

?>
