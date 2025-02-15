<?php
session_start();
include 'track_visit.php';
require 'db_connection.php'; // Asigură-te că acest fișier există și conține conexiunea la baza de date

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Setează sesiunea
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = htmlspecialchars($user["username"]); // Stocăm username-ul în sesiune
        $_SESSION["role"] = $user["role"];
        
        // Redirecționează către pagina principală sau un dashboard specific
        header("Location: index.php"); 
        exit;
    } else {
        $error = "Email sau parolă incorecte!";
    }
}
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Autentificare</div>
        <form method="POST">
            <div class="row">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="row">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Parolă" required>
            </div>
            <div class="row button">
                <input type="submit" value="Autentifică-te">
            </div>
            <div class="signup-link">Nu ai cont? <a href="register.php">Înregistrează-te</a></div>
        </form>
    </div>
</body>
</html>
