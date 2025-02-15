<?php
require 'db_connection.php';
session_start();
include 'track_visit.php';

// Preluăm toate rezervările cu statusul "pending"
$stmt = $pdo->prepare("
    SELECT reservations.id, users.username, hotels.name AS hotel_name, rooms.room_type, reservations.check_in, reservations.check_out
    FROM reservations
    JOIN users ON reservations.user_id = users.id
    JOIN rooms ON reservations.room_id = rooms.id
    JOIN hotels ON rooms.hotel_id = hotels.id
    WHERE reservations.status = 'pending'
");
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Dacă s-a trimis un formular pentru modificarea statusului
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $new_status = $_POST['status'];

    // Dacă statusul nou este "confirmed", verificăm condițiile impuse de trigger-e
    if ($new_status === 'confirmed') {
        // Preluăm detaliile rezervării
        $stmt = $pdo->prepare("
            SELECT room_id, check_in, check_out
            FROM reservations
            WHERE id = ?
        ");
        $stmt->execute([$reservation_id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificăm dacă camera este deja rezervată în perioada respectivă
        $stmt = $pdo->prepare("
            SELECT 1 
            FROM reservations
            WHERE room_id = ?
            AND status = 'confirmed'
            AND (
                (? BETWEEN check_in AND check_out)
                OR (? BETWEEN check_in AND check_out)
                OR (check_in BETWEEN ? AND ?)
                OR (check_out BETWEEN ? AND ?)
            )
        ");
        $stmt->execute([
            $reservation['room_id'],
            $reservation['check_in'], $reservation['check_out'],
            $reservation['check_in'], $reservation['check_out'],
            $reservation['check_in'], $reservation['check_out']
        ]);
        $is_room_booked = $stmt->fetch();

        if ($is_room_booked) {
            $error_message = 'The room is already booked for this period.';
        }

        // Verificăm dacă data de check-out este cel puțin o zi după check-in
        $check_in = new DateTime($reservation['check_in']);
        $check_out = new DateTime($reservation['check_out']);
        if ($check_out <= $check_in) {
            $error_message = 'Check-out date must be at least one day after check-in date.';
        }

        // Verificăm dacă data de check-in este anterioară datei curente
        $current_date = new DateTime();
        if ($check_in < $current_date) {
            $error_message = 'Check-in date cannot be in the past.';
        }
    }

    // Dacă nu există erori, actualizăm statusul rezervării
    if (!isset($error_message)) {
        $stmt = $pdo->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $reservation_id]);

        // Reîncărcăm pagina pentru a reflecta modificările
        header("Location: confirm_reservations.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmă Rezervări</title>
    <link rel="stylesheet" href="confirm_reservations.css">
</head>
<body>
    <div class="wrapper">
        <h1>Confirmă Rezervări</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Rezervare</th>
                    <th>Utilizator</th>
                    <th>Hotel</th>
                    <th>Tip Cameră</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation['id']; ?></td>
                        <td><?php echo $reservation['username']; ?></td>
                        <td><?php echo $reservation['hotel_name']; ?></td>
                        <td><?php echo $reservation['room_type']; ?></td>
                        <td><?php echo $reservation['check_in']; ?></td>
                        <td><?php echo $reservation['check_out']; ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                <select name="status">
                                    <option value="confirmed">Confirmă</option>
                                    <option value="cancelled">Anulează</option>
                                </select>
                                <button type="submit">Actualizează</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>