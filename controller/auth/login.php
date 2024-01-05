<?php
session_start();

include('../../conf/connection.php');

function increaseLoginAttempts($username) {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }

    if (!isset($_SESSION['login_attempts'][$username])) {
        $_SESSION['login_attempts'][$username] = 1;
    } else {
        $_SESSION['login_attempts'][$username]++;
    }
}

function isLoginAttemptsExceeded($username, $limit = 3) {
    return isset($_SESSION['login_attempts'][$username]) && $_SESSION['login_attempts'][$username] >= $limit;
}

function clearLoginAttempts($username) {
    unset($_SESSION['login_attempts'][$username]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];

    if (isLoginAttemptsExceeded($inputUsername)) {
        $error = "Login attempts exceeded. Please try again later.";
        header("Location: ../../pages/login.php?error=$error");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$inputUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($inputPassword, $user['password'])) {
        clearLoginAttempts($inputUsername);
        
        $_SESSION["user_id"] = $user['id'];
        $_SESSION["username"] = $inputUsername;
        header("Location: ../../pages/main.php");
        exit();
    } else {
        increaseLoginAttempts($inputUsername);

        $error = "Invalid username or password";
        header("Location: ../../pages/login.php?error=$error");
        exit();
    }
}
?>
