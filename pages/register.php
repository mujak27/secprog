<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
</head>
<body>

    <form action="../controller/auth/register.php" method="post">
        <h2>Register</h2>

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

        <button type="submit">Register</button>

        <!-- Add a button to redirect to login.php -->
        <p>Already have an account? <a href="login.php"><button type="button">Login</button></a></p>
    </form>

</body>
</html>
