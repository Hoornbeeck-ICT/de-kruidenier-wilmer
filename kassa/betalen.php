<?php
session_start();

$servername = "localhost";
$username1 = "root";
$password = "";
$db = "kruidenhuis";

$conn = new mysqli($servername, $username1, $password, $db);

if (!isset($_SESSION['producten']) || empty($_SESSION['producten'])) {
    echo "Geen producten in bestelling.";
    exit;
}

$totaal = 0;

foreach ($_SESSION['producten'] as $naam => $product) {
    $aantal = $product['aantal'];
    $prijs = $product['price'];

    $sql = "SELECT id FROM products WHERE name = '$naam'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $sql_insert = "INSERT INTO order_products (name, aantal) VALUES ('$naam', $aantal)";
        mysqli_query($conn, $sql_insert);

        $totaal += $prijs * $aantal;
    }
}

$btw = $totaal * 0.09;
$totaal_incl = $totaal + $btw;

unset($_SESSION['producten']);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Betaling</title>
</head>

<body>
    <h1>Bestelling afgerond</h1>
    <p>Subtotaal: €<?php echo $totaal ?></p>
    <p>BTW (9%): €<?php echo $btw ?></p>
    <p>Totaal incl. BTW: €<?php echo $totaal_incl ?></p>
    <a href="index.php">Terug naar kassa</a>
</body>

</html>