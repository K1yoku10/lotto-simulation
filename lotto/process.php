<?php
require 'lotto.php';
require 'db_connect.php';

// Pobranie liczb od użytkownika
$userNumbers = $_POST['userNumbers']; // Tablica liczb użytkownika
$randomNumbers = generateRandomNumbers(1, 49, 6);
$userNumbersStr = implode(", ", $userNumbers);
$randomNumbersStr = implode(", ", $randomNumbers);
$matches = checkMatches($userNumbers, $randomNumbers);
$numberOfMatches = count($matches);
$matchesCount = $numberOfMatches;

// Sprawdzenie, czy liczby są unikalne
if (count($userNumbers) !== count(array_unique($userNumbers))) {
    echo "Liczby muszą być unikalne!";
    exit();
}

// Walidacja liczb
$userNumbers = array_filter($userNumbers, function ($num) {
    return is_numeric($num) && $num >= 1 && $num <= 49;
});

// Przygotowanie zapytania SQL
$sql = "INSERT INTO results (user_numbers, random_numbers, matches) VALUES (:user_numbers, :random_numbers, :matches)";
$stmt = $pdo->prepare($sql);

// Powiązanie parametrów
$stmt->bindParam(':user_numbers', $userNumbersStr);
$stmt->bindParam(':random_numbers', $randomNumbersStr);
$stmt->bindParam(':matches', $matchesCount);

// Wykonanie zapytania
$stmt->execute();

// Obliczenie nagrody
$prize = '';
switch ($numberOfMatches) {
    case 6: $prize = "1 000 000 zł"; break;
    case 5: $prize = "50 000 zł"; break;
    case 4: $prize = "5 000 zł"; break;
    case 3: $prize = "500 zł"; break;
    default: $prize = "0 zł"; break;
}

// Wyświetlanie wyników w HTML
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyniki Lotto</title>
    <link rel="stylesheet" href="style1.css"> <!-- Styl CSS -->
</head>
<body>
    <div class="container">
        <h1>Wyniki Lotto</h1>
        <p>Twoje liczby: <span class="numbers"><?php echo implode(", ", $userNumbers); ?></span></p>
        <p>Wylosowane liczby: <span class="numbers"><?php echo implode(", ", $randomNumbers); ?></span></p>
        <p>Trafiłeś <strong><?php echo $numberOfMatches; ?></strong> liczb(y): 
            <span class="matches"><?php echo implode(", ", $matches); ?></span>
        </p>
        <p>Twoja nagroda: <strong><?php echo $prize; ?></strong></p>
        <p>
            <?php 
            if ($numberOfMatches == 6) {
                echo "Gratulacje! Wygrałeś główną nagrodę!";
            } elseif ($numberOfMatches == 5) {
                echo "Wygrałeś drugą nagrodę!";
            } elseif ($numberOfMatches >= 3) {
                echo "Wygrałeś nagrodę pocieszenia!";
            } else {
                echo "Niestety, nie wygrałeś. Spróbuj ponownie.";
            }
            ?>
        </p>
        <a href="index.php" class="retry-button">Spróbuj ponownie</a>
    </div>
</body>
</html>

<?php
// Funkcje
function generateRandomNumbers($min, $max, $quantity) {
    $numbers = [];
    while (count($numbers) < $quantity) {
        $number = rand($min, $max);
        if (!in_array($number, $numbers)) {
            $numbers[] = $number;
        }
    }
    return $numbers;
}

function checkMatches($userNumbers, $randomNumbers) {
    return array_intersect($userNumbers, $randomNumbers);
}
?>
