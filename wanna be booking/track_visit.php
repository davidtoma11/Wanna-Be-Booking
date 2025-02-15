<?php
require 'db_connection.php';

// Verificăm dacă conexiunea la baza de date a fost stabilită cu succes
if (!$pdo) {
    die("Eroare la conectarea la baza de date.");
}

// Preluăm datele despre vizitator
$page_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$visit_time = date('Y-m-d H:i:s'); // Data și ora curentă

// Validăm și curățăm datele
$page_url = filter_var($page_url, FILTER_SANITIZE_URL);
$ip_address = filter_var($ip_address, FILTER_VALIDATE_IP);

// Verificăm dacă datele sunt valide înainte de inserare
if ($page_url && $ip_address) {
    try {
        // Inserăm datele în tabelul analytics
        $stmt = $pdo->prepare("
            INSERT INTO analytics (user_ip, page, visit_time)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$ip_address, $page_url, $visit_time]);
    } catch (PDOException $e) {
        die("Eroare la inserarea datelor în baza de date: " . $e->getMessage());
    }
} else {
    die("Date invalide pentru inserare.");
}
?>