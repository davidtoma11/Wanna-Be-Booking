<?php
session_start();
include 'track_visit.php';

if ($_SESSION['role'] != 'admin') {
    echo '
    <!DOCTYPE html>
    <html lang="ro">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acces interzis</title>
        <link rel="stylesheet" href="reports.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="title">Acces interzis</div>
            <div class="content">
                <div class="error-message">
                    Nu ai permisiunea de a accesa această pagină!
                </div>
                <a href="index.php">Înapoi la pagina principală</a>
            </div>
        </div>
    </body>
    </html>
    ';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Privileges</title>
    <link rel="stylesheet" href="admin_privileges.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Admin Privileges</div>
        <div class="content">
            <h1>Bine ai venit, Admin!</h1>
            <div class="nav-links">
                <a href="reports.php">Reports</a>
                <a href="analytics.php">Analytics</a>
                <a href="modify.php">Modify</a>
                <a href="confirm_reservations.php">Confirm Reservations</a>
            </div>
        </div>
    </div>
</body>
</html>