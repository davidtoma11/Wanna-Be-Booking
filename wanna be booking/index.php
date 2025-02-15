<?php
session_start();
include 'track_visit.php';
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Wanna Be Booking</div>
        <div class="content">
            <h1>Home Page</h1>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>Salut, <?php echo $_SESSION['username']; ?>! <a href="logout.php">Deconectează-te</a></p>
                <div class="nav-links">
                    <a href="rooms.php">Vezi camerele disponibile</a>
                    <a href="your_reservations.php">Vezi rezervările tale</a>
                    <a href="admin_privileges.php">Admin Privileges</a>
                    <a href="contact.php">Contactează-ne</a>
                </div>
            <?php else: ?>
                <div class="nav-links">
                    <a href="login.php">Autentifică-te</a>
                    <a href="register.php">Înregistrează-te</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
