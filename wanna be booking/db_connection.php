<?php
$host = 'localhost';
$db = 'wbb';
$user = 'root'; // sau alt utilizator dacă folosești altul
$password = ''; // adaugă parola dacă este necesară

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

