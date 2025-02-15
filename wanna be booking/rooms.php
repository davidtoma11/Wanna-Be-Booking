<?php
require 'db_connection.php';
session_start();
include 'track_visit.php';

// Preluăm camerele disponibile împreună cu numele hotelului
$stmt = $pdo->prepare("
    SELECT rooms.*, hotels.name AS hotel_name
    FROM rooms
    JOIN hotels ON rooms.hotel_id = hotels.id
");
$stmt->execute();
$rooms = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camere disponibile</title>
    <link rel="stylesheet" href="rooms.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Camere Disponibile</div>
        <div class="content">
            <h1>Camere Disponibile</h1>
            <div class="room-list">
                <?php foreach ($rooms as $room): ?>
                    <div class="room-item">
                        <h3><?php echo $room['hotel_name'] . ': ' . $room['room_type']; ?></h3>
                        <p>Preț: <?php echo $room['price']; ?> RON</p>
                        <a href="details.php?room_id=<?php echo $room['id']; ?>">Detalii</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>