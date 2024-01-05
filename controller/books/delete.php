<?php
require_once __DIR__ . '/../../conf/connection.php';

require_once __DIR__ . '/../auth/middleware.php';
checkLogin();

function deleteBook(PDO $pdo, $bookId) {
    try {
        
        $checkBookQuery = "SELECT * FROM books WHERE id = ?";
        $checkBookStmt = $pdo->prepare($checkBookQuery);
        $checkBookStmt->execute([$bookId]);
        $existingBook = $checkBookStmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingBook) {
            
            return false;
        }

        
        $deleteBookQuery = "DELETE FROM books WHERE id = ?";
        $deleteBookStmt = $pdo->prepare($deleteBookQuery);
        $deleteBookStmt->execute([$bookId]);

        
        return true;
    } catch (PDOException $e) {
        
        die("Error deleting book: " . $e->getMessage());
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $bookId = $_POST['id'];
            $deleted = deleteBook($pdo, $bookId);
            if ($deleted) {
                
                header("Location: ../../pages/main.php");
                exit();
            } else {
                echo "Book with ID $bookId not found.";
            }
        }
    }
    }
?>
