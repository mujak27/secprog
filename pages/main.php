<?php
require_once '../controller/auth/middleware.php';
require_once '../controller/books/get.php';


checkLogin();

$loggedInUserId = $_SESSION['user_id'];
$allBooks = getAllBooks($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<body>

<h1>Welcome to the Main Page</h1>

<form action="../controller/auth/logout.php" method="post">
    <button type="submit">Logout</button>
</form>

<!-- Insert Button -->
<a href="insert.php">Insert New Book</a>

<?php

if (!empty($allBooks)) {
    echo "<h2>All Books:</h2>";
    echo "<ul>";
    foreach ($allBooks as $book) {
        $bookName = htmlspecialchars($book['name'], ENT_QUOTES, 'UTF-8');
        $userIdOwner = htmlspecialchars($book['user_id'], ENT_QUOTES, 'UTF-8');

        echo "<li>name: " . $bookName . ", user id owner: " . $userIdOwner . " ";
        
        if ($book['user_id'] === $loggedInUserId) {
            $bookId = htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8');
            
            echo "<a href='updateBook.php?id=" . $bookId . "'>Update</a>";
            
            $csrfToken = bin2hex(random_bytes(32));
            
            $_SESSION['csrf_token'] = $csrfToken;
            
            echo "<form method='post' action='../controller/books/delete.php' style='display:inline;'>
                      <input type='hidden' name='id' value='" . $bookId . "'>
                      <input type='hidden' name='csrf_token' value='" . $csrfToken . "'>
                      <input type='submit' value='Delete' onclick='return confirm(\"Are you sure you want to delete this book?\")'>
                  </form>";
        }
        
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No books available.</p>";
}

?>

<!-- Add any other content or functionality you want on this page -->

</body>
</html>
