<?php
session_start();
if (isset($_SESSION['login'])) {
    
    $servername = "localhost";
    $username1 = "root";
    $password = "";
    $db = "kruidenhuis";

    $conn = new mysqli($servername, $username1, $password, $db);
    $username = $_SESSION['login'];
    $sql = "SELECT admin FROM login WHERE username = '" . $username . "'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['admin'] == 1) {


        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $verwijdersql = "DELETE FROM products WHERE id = $id";
            $result = mysqli_query($conn, $verwijdersql);
        }

        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $hoeveelheid = $_POST['hoeveelheid'];
            $updatesql = "UPDATE products SET name = '$name', price = '$price', hoeveelheid = '$hoeveelheid' WHERE id = $id";
            $result = mysqli_query($conn, $updatesql);
        }

        if (isset($_POST['voegToe'])) {
            $name = $_POST['nameNew'];
            $price = $_POST['priceNew'];
            $hoeveelheid = $_POST['hoeveelheidNew'];
            $toevoegsql = "INSERT INTO products (name, price, hoeveelheid) VALUES ('$name', '$price', '$hoeveelheid')";
            $result = mysqli_query($conn, $toevoegsql);
        }

        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        </head>

        <body class="overflow-hidden h-screen">
            <header class="shadow-md p-4 bg-[#4CAF50]">
                <div class="flex items-center justify-between">
                    <a href="../logout.php"
                        class="bg-white text-red-500 hover:text-red-700 px-4 py-2 rounded shadow-md">Uitloggen</a>
                    <a href="../kassa" class="ml-auto">
                        <h1 class="text-xl mx-5">Kassa</h1>
                    </a>
                    <h1 class="text-xl">Beheer</h1>
                </div>
            </header>
            <div class="flex h-full">
                <div class="w-3/4 bg-[#F6EACA]">
                    <?php
                    $sql = "SELECT * FROM products";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<form method="post" class="p-4">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <input type="text" name="name" value="' . $row['name'] . '" class="block w-full border p-2 mb-2 rounded">
                        <input type="number" step="0.01" name="price" value="' . $row['price'] . '" class="block w-full border p-2 mb-2 rounded">
                        <input type="number" name="hoeveelheid" value="' . $row['hoeveelheid'] . '" class="block w-full border p-2 mb-2 rounded">
                        <div class="flex space-x-2">
                        <button type="submit" name="update" class="bg-green-500 text-white px-4 py-2 rounded">Opslaan</button>
                        <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2 rounded">Verwijderen</button>
                        </div>
                        </form>';
                    }
                    ?>
                </div>
                <div class="w-1/4 bg-[#F6EACA] p-4">
                    <h2 class="text-xl mb-4">Nieuw product toevoegen</h2>
                    <form method="post" class="space-y-4">
                        <input type="text" name="nameNew" placeholder="Naam" class="block w-full border p-2 rounded">
                        <input type="number" step="0.01" name="priceNew" placeholder="Prijs" class="block w-full border p-2 rounded">
                        <input type="number" name="hoeveelheidNew" placeholder="Hoeveelheid" class="block w-full border p-2 rounded">
                        <button type="submit" name="voegToe" class="bg-gray-500 text-white px-4 py-2 rounded">Voeg product toe</button>
                    </form>
                </div>
            </div>

        </body>

        </html>

        <?php
    } else {
        header('location:../home');
    }
} else {
    header('location:../home');
}
?>
