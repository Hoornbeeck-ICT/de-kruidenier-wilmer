<?php
session_start();

$servername = "localhost";
$username1 = "root";
$password = "";
$db = "kruidenhuis";

$conn = new mysqli($servername, $username1, $password, $db);

if (isset($_SESSION['producten'])) {
    foreach ($_SESSION['producten'] as $product) {
        $naam = $product['name'];
        $aantal = $product['aantal'];
        mysqli_query($conn, "UPDATE products SET hoeveelheid = hoeveelheid + $aantal WHERE name = '$naam'");
    }
    unset($_SESSION['producten']);
}

header("Location: index.php");
exit;