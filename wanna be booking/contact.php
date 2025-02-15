<?php
include 'track_visit.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to = 'email@example.com'; // Email-ul tău
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $headers = 'From: ' . $_POST['email'];

    if (mail($to, $subject, $message, $headers)) {
        echo '<div class="message success">Mesaj trimis cu succes!</div>';
    } else {
        echo '<div class="message error">A apărut o eroare!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Contact</div>
        <div class="content">
            <h1>Contactează-ne</h1>
            <form action="contact.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="subject">Subiect:</label>
                <input type="text" name="subject" required>

                <label for="message">Mesaj:</label>
                <textarea name="message" required></textarea>

                <button type="submit">Trimite mesaj</button>
            </form>
        </div>
    </div>
</body>
</html>