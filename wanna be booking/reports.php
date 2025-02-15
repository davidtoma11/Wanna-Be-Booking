<?php
require 'db_connection.php';
session_start();
include 'track_visit.php';
// Verificăm dacă utilizatorul este admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Preluăm toate rezervările
$stmt = $pdo->prepare("SELECT * FROM reservations");
$stmt->execute();
$reservations = $stmt->fetchAll();

// Statistici pe lună
$stmt = $pdo->prepare("
    SELECT 
        DATE_FORMAT(check_in, '%Y-%m') AS luna,
        COUNT(*) AS numar_rezervari,
        SUM(rooms.price) AS suma_totala
    FROM reservations
    JOIN rooms ON reservations.room_id = rooms.id
    WHERE reservations.status = 'confirmed'
    GROUP BY DATE_FORMAT(check_in, '%Y-%m')
");
$stmt->execute();
$monthly_stats = $stmt->fetchAll();

// Statistici pe hoteluri
$stmt = $pdo->prepare("
    SELECT 
        hotels.name AS hotel,
        COUNT(*) AS numar_rezervari,
        SUM(rooms.price) AS suma_totala
    FROM reservations
    JOIN rooms ON reservations.room_id = rooms.id
    JOIN hotels ON rooms.hotel_id = hotels.id
    WHERE reservations.status = 'confirmed'
    GROUP BY hotels.name
");
$stmt->execute();
$hotel_stats = $stmt->fetchAll();

// Cod pentru export CSV
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="rapoarte.csv"');

    $output = fopen('php://output', 'w');

    // Header pentru rezervări
    fputcsv($output, ['ID', 'Utilizator', 'Camere', 'Check-in', 'Check-out', 'Status']);

    // Date pentru rezervări
    if (isset($reservations) && is_array($reservations)) {
        foreach ($reservations as $reservation) {
            fputcsv($output, [
                $reservation['id'],
                $reservation['user_id'],
                $reservation['room_id'],
                $reservation['check_in'],
                $reservation['check_out'],
                $reservation['status']
            ]);
        }
    } else {
        fputcsv($output, ['Nu există rezervări.']);
    }

    // Adăugăm un rând gol pentru separare
    fputcsv($output, []);

    // Header pentru statistici pe lună
    fputcsv($output, ['Statistici pe lună']);
    fputcsv($output, ['Luna', 'Număr rezervări', 'Suma totală (RON)']);

    // Date pentru statistici pe lună
    if (isset($monthly_stats) && is_array($monthly_stats)) {
        foreach ($monthly_stats as $stat) {
            fputcsv($output, [
                $stat['luna'],
                $stat['numar_rezervari'],
                number_format($stat['suma_totala'], 2)
            ]);
        }
    } else {
        fputcsv($output, ['Nu există statistici pe lună.']);
    }

    // Adăugăm un rând gol pentru separare
    fputcsv($output, []);

    // Header pentru statistici pe hoteluri
    fputcsv($output, ['Statistici pe hoteluri']);
    fputcsv($output, ['Hotel', 'Număr rezervări', 'Suma totală (RON)']);

    // Date pentru statistici pe hoteluri
    if (isset($hotel_stats) && is_array($hotel_stats)) {
        foreach ($hotel_stats as $stat) {
            fputcsv($output, [
                $stat['hotel'],
                $stat['numar_rezervari'],
                number_format($stat['suma_totala'], 2)
            ]);
        }
    } else {
        fputcsv($output, ['Nu există statistici pe hoteluri.']);
    }

    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapoarte</title>
    <link rel="stylesheet" href="reports.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Rapoarte</div>
        <div class="content">
            <h1>Rapoarte rezervări</h1>

            <!-- Butoane pentru export -->
            <div class="export-buttons">
                <a href="reports.php?export=csv" class="export-button">Exportă CSV</a>
            </div>

            <!-- Tabel cu toate rezervările -->
            <h2>Toate rezervările</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Utilizator</th>
                    <th>Camere</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation['id']; ?></td>
                        <td><?php echo $reservation['user_id']; ?></td>
                        <td><?php echo $reservation['room_id']; ?></td>
                        <td><?php echo $reservation['check_in']; ?></td>
                        <td><?php echo $reservation['check_out']; ?></td>
                        <td><?php echo $reservation['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <!-- Statistici pe lună -->
            <h2>Statistici pe lună</h2>
            <table>
                <tr>
                    <th>Luna</th>
                    <th>Număr rezervări</th>
                    <th>Suma totală (RON)</th>
                </tr>
                <?php foreach ($monthly_stats as $stat): ?>
                    <tr>
                        <td><?php echo $stat['luna']; ?></td>
                        <td><?php echo $stat['numar_rezervari']; ?></td>
                        <td><?php echo number_format($stat['suma_totala'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <!-- Statistici pe hoteluri -->
            <h2>Statistici pe hoteluri</h2>
            <table>
                <tr>
                    <th>Hotel</th>
                    <th>Număr rezervări</th>
                    <th>Suma totală (RON)</th>
                </tr>
                <?php foreach ($hotel_stats as $stat): ?>
                    <tr>
                        <td><?php echo $stat['hotel']; ?></td>
                        <td><?php echo $stat['numar_rezervari']; ?></td>
                        <td><?php echo number_format($stat['suma_totala'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <a href="index.php">Înapoi la pagina principală</a>
        </div>
    </div>
</body>
</html>