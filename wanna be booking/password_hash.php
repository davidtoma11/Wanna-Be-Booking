<?php
// Parolele originale
$passwords = [
    'martin',
    'sara2001',
    'proiectphp2025februarie',
    'Receptie1234',
    'RECEPTIE22'
];

// Generare hash-uri
foreach ($passwords as $password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    echo "Parola: $password\n";
    echo "Hash: $hash\n\n";
}
?>
