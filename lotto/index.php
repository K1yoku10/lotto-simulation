<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby grać.<br> <a href='login.php'>Zaloguj Się<br></a><a href='register.php'>Zarejestruj Się</a>.<br>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symulator Lotto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Symulator Lotto</h1>
        
        <!-- Obrazki kul losujących po przeciwnych stronach -->
        <div class="ball-left">
            <img src="ball1.png" alt="Kula losująca 1" class="lotto-ball">
        </div>
        <div class="ball-right">
            <img src="ball2.png" alt="Kula losująca 2" class="lotto-ball">
        </div>

        <!-- Formularz do wpisywania liczb -->
        <form action="process.php" method="post" class="lotto-form">
            <label>Wybierz 6 liczb (1-49):</label><br>
            <?php for ($i = 1; $i <= 6; $i++): ?>
                <input type="number" name="userNumbers[]" min="1" max="49" required><br>
            <?php endfor; ?>
            <input type="submit" value="Zagraj" class="submit-button">
        </form>

        <div id="result"></div>
        <div id="loader" style="display:none;">Ładowanie...</div>

        <p><a href="results.php" class="history-link">Zobacz historię gier</a></p>
        <p>Witaj, <?php echo $_SESSION['username']; ?>! <a href="logout.php">Wyloguj się</a></p>
    </div>
</body>
</html>