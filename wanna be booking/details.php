<?php
require 'db_connection.php';
session_start();
include 'track_visit.php';

// Preluăm ID-ul camerei din URL
if (!isset($_GET['room_id'])) {
    echo "Cameră invalidă!";
    exit;
}
$room_id = $_GET['room_id'];

// Preluăm detaliile camerei și ale hotelului asociat
$stmt = $pdo->prepare("
    SELECT rooms.*, hotels.name AS hotel_name, hotels.description AS hotel_description, hotels.rating AS hotel_rating, hotels.location
    FROM rooms
    JOIN hotels ON rooms.hotel_id = hotels.id
    WHERE rooms.id = ?
");
$stmt->execute([$room_id]);
$room = $stmt->fetch();

if (!$room) {
    echo "Cameră invalidă!";
    exit;
}

// Extragem doar primul cuvânt din câmpul `location` (numele orașului)
$locationParts = explode(',', $room['location']); // Separăm după virgulă
$city = trim($locationParts[0]); // Luăm prima parte și eliminăm spațiile în plus

// Codifică numele orașului pentru URL
$cityEncoded = urlencode($city);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii cameră</title>
    <link rel="stylesheet" href="details.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Detalii cameră</div>
        <div class="content">
            <h1><?php echo $room['room_type']; ?></h1>
            <div class="room-details">
                <h3>Descriere hotel:</h3>
                <p><?php echo $room['hotel_description']; ?></p>

                <h3>Rating hotel:</h3>
                <p><?php echo str_repeat('★', (int)$room['hotel_rating']) . str_repeat('☆', 5 - (int)$room['hotel_rating']) . ' (' . $room['hotel_rating'] . '/5)'; ?></p>

                <h3>Preț:</h3>
                <p class="price"><?php echo $room['price']; ?> RON pe noapte</p>

                <!-- Widget de vreme pentru orașul hotelului -->
                <h3>Vremea în <?php echo $city; ?>:</h3>
                <iframe 
                    src="https://weatherwidget.io/embed.html?city=<?php echo $cityEncoded; ?>&country=RO" 
                    style="width:100%;border:none;" 
                    height="150">
                </iframe>

                <a href="book_room.php?room_id=<?php echo $room['id']; ?>">Rezervă acum</a>
            </div>
        </div>
    </div>
</body>
</html>