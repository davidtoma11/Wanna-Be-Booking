<?php
require 'db_connection.php';
session_start();
include 'track_visit.php';

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirecționează către login dacă nu este autentificat
    exit;
}

// Preluăm ID-ul camerei din URL
if (!isset($_GET['room_id'])) {
    echo "Cameră invalidă!";
    exit;
}
$room_id = $_GET['room_id'];

// Preluăm detaliile camerei
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$room_id]);
$room = $stmt->fetch();

if (!$room) {
    echo "Cameră invalidă!";
    exit;
}

$error = ""; // Variabilă pentru mesajul de eroare

// Procesăm formularul de rezervare
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $user_id = $_SESSION['user_id'];

    try {
        // Verificăm dacă camera este disponibilă în perioada selectată
        $stmt = $pdo->prepare("SELECT * FROM reservations WHERE room_id = ? AND status = 'confirmed' AND ((check_in <= ? AND check_out >= ?) OR (check_in <= ? AND check_out >= ?))");
        $stmt->execute([$room_id, $check_in, $check_in, $check_out, $check_out]);

        if ($stmt->fetch()) {
            $error = "Camera nu este disponibilă în perioada selectată!";
        } else {
            // Inserăm rezervarea în baza de date
            $stmt = $pdo->prepare("INSERT INTO reservations (user_id, room_id, check_in, check_out, status) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->execute([$user_id, $room_id, $check_in, $check_out]);

            $success = "Rezervarea a fost trimisă cu succes!";
        }
    } catch (PDOException $e) {
        // Prindem excepția și afișăm un mesaj de eroare
        if ($e->getCode() == '45000') { // Codul de eroare pentru trigger
            if (strpos($e->getMessage(), 'Data de check-in') !== false) {
                $error = "Data de check-in nu poate fi anterioară datei curente.";
            } else {
                $error = "Data de check-out trebuie să fie cel puțin o zi după data de check-in.";
            }
        } else {
            $error = "A apărut o eroare la trimiterea rezervării: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervă camera</title>
    <link rel="stylesheet" href="book_room.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Rezervă camera</div>
        <div class="content">
            <h1>Rezervă <?php echo $room['room_type']; ?></h1>
            <?php if (isset($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="message success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST">
                <label for="check_in">Check-in:</label>
                <input type="date" name="check_in" value="<?php echo isset($_POST['check_in']) ? $_POST['check_in'] : ''; ?>" required>

                <label for="check_out">Check-out:</label>
                <input type="date" name="check_out" value="<?php echo isset($_POST['check_out']) ? $_POST['check_out'] : ''; ?>" required>

                <button type="submit">Rezervă acum</button>
            </form>
        </div>
    </div>
</body>
</html>