<?php
require 'db_connection.php';
session_start();
include 'track_visit.php';

// Verificăm dacă utilizatorul este conectat
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Preluăm toate rezervările utilizatorului conectat
$stmt = $pdo->prepare("
    SELECT reservations.id, hotels.name AS hotel_name, rooms.room_type, reservations.check_in, reservations.check_out, reservations.status
    FROM reservations
    JOIN rooms ON reservations.room_id = rooms.id
    JOIN hotels ON rooms.hotel_id = hotels.id
    WHERE reservations.user_id = ?
");
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Dacă s-a trimis un formular pentru anularea unei rezervări
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
    $reservation_id = $_POST['reservation_id'];

    // Actualizăm statusul rezervării la "cancelled"
    $stmt = $pdo->prepare("UPDATE reservations SET status = 'cancelled' WHERE id = ? AND user_id = ?");
    $stmt->execute([$reservation_id, $user_id]);

    // Reîncărcăm pagina pentru a reflecta modificările
    header("Location: your_reservations.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervările Mele</title>
    <link rel="stylesheet" href="your_reservations.css">
</head>
<body>
    <div class="wrapper">
        <h1>Rezervările Mele</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Rezervare</th>
                    <th>Hotel</th>
                    <th>Tip Cameră</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation['id']; ?></td>
                        <td><?php echo $reservation['hotel_name']; ?></td>
                        <td><?php echo $reservation['room_type']; ?></td>
                        <td><?php echo $reservation['check_in']; ?></td>
                        <td><?php echo $reservation['check_out']; ?></td>
                        <td><?php echo $reservation['status']; ?></td>
                        <td>
                            <?php if ($reservation['status'] === 'pending' || $reservation['status'] === 'confirmed'): ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                    <button type="submit" name="cancel">Anulează</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php">Înapoi la pagina principală</a>
    </div>
</body>
</html>