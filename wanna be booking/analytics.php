<?php
require 'db_connection.php';
session_start();
include 'track_visit.php';

// Verificăm dacă utilizatorul este admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Preluăm numărul total de vizitatori
$stmt = $pdo->prepare("SELECT COUNT(DISTINCT user_ip) AS total_visitors FROM analytics");
$stmt->execute();
$total_visitors = $stmt->fetchColumn();

// Preluăm numărul total de accesări
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_visits FROM analytics");
$stmt->execute();
$total_visits = $stmt->fetchColumn();

// Preluăm cele mai accesate pagini
$stmt = $pdo->prepare("
    SELECT page, COUNT(*) AS visits
    FROM analytics
    GROUP BY page
    ORDER BY visits DESC
    LIMIT 10
");
$stmt->execute();
$most_visited_pages = $stmt->fetchAll();

// Preluăm vizitatorii unici pe lună
$stmt = $pdo->prepare("
    SELECT DATE_FORMAT(visit_time, '%Y-%m') AS month, COUNT(DISTINCT user_ip) AS unique_visitors
    FROM analytics
    GROUP BY DATE_FORMAT(visit_time, '%Y-%m')
    ORDER BY month DESC
");
$stmt->execute();
$monthly_unique_visitors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="analytics.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Analytics</div>
        <div class="content">
            <h1>Statistici site</h1>

            <!-- Vizitatori totali -->
            <div class="stat-box">
                <h2>Vizitatori totali:</h2>
                <p><?php echo $total_visitors; ?></p>
            </div>

            <!-- Accesări totale -->
            <div class="stat-box">
                <h2>Accesări totale:</h2>
                <p><?php echo $total_visits; ?></p>
            </div>

            <!-- Cele mai accesate pagini -->
            <div class="stat-box">
                <h2>Cele mai accesate pagini:</h2>
                <table>
                    <tr>
                        <th>Pagina</th>
                        <th>Accesări</th>
                    </tr>
                    <?php foreach ($most_visited_pages as $page): ?>
                        <tr>
                            <td><?php echo $page['page']; ?></td>
                            <td><?php echo $page['visits']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <!-- Vizitatori unici pe lună -->
            <div class="stat-box">
                <h2>Vizitatori unici pe lună:</h2>
                <table>
                    <tr>
                        <th>Luna</th>
                        <th>Vizitatori unici</th>
                    </tr>
                    <?php foreach ($monthly_unique_visitors as $stat): ?>
                        <tr>
                            <td><?php echo $stat['month']; ?></td>
                            <td><?php echo $stat['unique_visitors']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <a href="index.php">Înapoi la pagina principală</a>
        </div>
    </div>
</body>
</html>