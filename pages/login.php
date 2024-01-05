<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>

<form action="../controller/auth/login.php" method="post">
    <h2>Login</h2>

    <?php
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        echo "<p>Error: " . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</p>";
    }
    ?>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>

    <!-- Add a button to redirect to register.php -->
    <p>Don't have an account? <a href="register.php"><button type="button">Register</button></a></p>
</form>

</body>
</html>
