<?php
session_start();
include 'track_visit.php';
require 'db_connection.php'; // Conexiunea la baza de date

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]); // Numele utilizatorului
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        $error = "Parolele nu coincid!";
    } else {
        // Verifică dacă email-ul există deja
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Acest email este deja utilizat!";
        } else {
            // Hash-uim parola
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Inserăm noul utilizator (automat ca `client`)
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'client')");
            if ($stmt->execute([$username, $email, $hashed_password])) {
                // Autentifică automat utilizatorul după înregistrare
                $_SESSION["user_id"] = $pdo->lastInsertId();
                $_SESSION["username"] = htmlspecialchars($username); // Salvăm username-ul în sesiune
                $_SESSION["role"] = 'client';

                // Redirecționare către index.php
                header("Location: index.php");
                exit;
            } else {
                $error = "Eroare la înregistrare. Încearcă din nou!";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Înregistrare</div>
        <form method="POST">
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <div class="row">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="row">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="row">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Parolă" required>
            </div>
            <div class="row">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" placeholder="Confirmă Parola" required>
            </div>
            <div class="row button">
                <input type="submit" value="Înregistrează-te">
            </div>
            <div class="login-link">Ai deja cont? <a href="login.php">Autentifică-te</a></div>
        </form>
    </div>
</body>
</html>
