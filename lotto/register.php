<?php
require 'db_connect2.php'; // Plik z połączeniem z bazą danych

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sprawdzanie, czy dane zostały przesłane
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Walidacja danych
    if (empty($username) || empty($password)) {
        echo "Nazwa użytkownika i hasło nie mogą być puste.";
        exit();
    }

    // Hashowanie hasła
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Przygotowanie zapytania SQL do dodania użytkownika
    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);

    // Wykonanie zapytania
    if ($stmt->execute()) {
        echo "Rejestracja zakończona sukcesem!";
    } else {
        echo "Wystąpił problem podczas rejestracji.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <h1>Rejestracja</h1>
    <form action="register.php" method="POST">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Hasło:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Zarejestruj się">
    </form>
</body>
</html>
