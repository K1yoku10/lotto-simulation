<?php
session_start();
require 'db_connect2.php'; // Plik z połączeniem z bazą danych

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sprawdzenie, czy dane zostały wypełnione
    if (empty($username) || empty($password)) {
        echo "Nazwa użytkownika i hasło nie mogą być puste.";
        exit();
    }

    // Pobranie użytkownika z bazy danych
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Zalogowanie użytkownika
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "Zalogowano pomyślnie!";
        header("Location: index.php"); // Przekierowanie na stronę główną po zalogowaniu
        exit();
    } else {
        echo "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <h1>Logowanie</h1>
    <form action="login.php" method="POST">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Hasło:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Zaloguj się">
    </form>
</body>
</html>

