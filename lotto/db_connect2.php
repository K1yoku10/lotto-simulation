<?php
$host = 'localhost'; // Adres hosta bazy danych
$dbname = 'lotto_db'; // Nazwa bazy danych
$username = 'root'; // Nazwa użytkownika bazy danych
$password = ''; // Hasło do bazy danych (jeśli jest ustawione)

try {
    // Utworzenie połączenia z bazą danych
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Obsługa błędów
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}
?>
