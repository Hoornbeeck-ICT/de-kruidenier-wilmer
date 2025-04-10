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
    if ($row['admin'] == 1 or $row['admin'] == 0) {
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
            <script type="text/javascript" src="../script.js"></script>
        </head>

        <body>
            <header class=" p-4 bg-[#4CAF50]">
                <div class="flex items-center justify-between ">
                    <a href="../logout.php"
                        class="bg-white text-red-500 hover:text-red-700 px-4 py-2 rounded shadow-md">Uitloggen</a>
                    <a href="delete.php">
                        <img src="../png/image.png" alt="Afbeelding" class="w-16 h-16">
                    </a>
                    <?php if($row['admin'] == 1) { ?>
                    <a href="../Beheer" class="ml-auto">
                        <h1 class="text-xl mx-5">Beheer</h1>
                    </a>
                    <?php } ?>
                    <h1 class="text-xl">Kassa</h1>
                </div>
            </header>

            <div class="flex justify-between bg-[#F6EACA]">

                <div class="w-full md:w-1/2 p-4">
                    <div class="flex flex-col items-center p-6 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <form method="post" class="w-full mb-4 flex items-center">
                                <input type="number" name="input" id="input"
                                    class="block border p-4 w-full text-center mb-4 rounded-lg text-xl"
                                    placeholder="Voer een barcode in">


                        </div>

                        <div class="grid grid-cols-3 gap-4 w-full">
                            <input type="button" name="btn1" id="btn1" value="1" onclick="btn('1')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btn2" id="btn2" value="2" onclick="btn('2')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btn3" id="btn3" value="3" onclick="btn('3')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btn4" id="btn4" value="4" onclick="btn('4')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btn5" id="btn5" value="5" onclick="btn('5')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btn6" id="btn6" value="6" onclick="btn('6')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btn7" id="btn7" value="7" onclick="btn('7')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btn8" id="btn8" value="8" onclick="btn('8')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btn9" id="btn9" value="9" onclick="btn('9')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="button" name="btnC" id="btnC" value="C" onclick="operatorC()"
                                class="border p-8 bg-gray-400 rounded-lg text-xl">
                            <input type="button" name="btn0" id="btn0" value="0" onclick="btn('0')"
                                class="border p-8 bg-gray-200 rounded-lg text-xl">
                            <input type="submit" name="btnadd" value="ADD" class="border p-8 bg-gray-400 rounded-lg text-xl">
                            <a href="betalen.php">
                                <input type="button" name="btnbuy" value="Bestelling afronden"
                                    class="border col-span-3 p-8 bg-gray-400 rounded-lg text-xl">
                            </a>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="w-full md:w-1/2 p-4">
                    <?php
                    if ($_POST) {

                        $id = $_POST['input'];


                        $sql = "SELECT `id`, `name`, `price`, `hoeveelheid` FROM `products` WHERE id = $id";
                        $result = mysqli_query($conn, $sql);

                        if ($result->num_rows == 0) {
                            echo "Geen product gevonden met dit id<br>";
                        } else {
                            $row = mysqli_fetch_assoc($result);

                            if ($row['hoeveelheid'] > 0) {
                                if (!isset($_SESSION['producten'][$row['name']])) {
                                    $_SESSION['producten'][$row['name']] = [
                                        'name' => $row['name'],
                                        'price' => $row['price'],
                                        'aantal' => 1
                                    ];
                                } else {
                                    $_SESSION['producten'][$row['name']]['aantal'] += 1;
                                }

                                mysqli_query($conn, "UPDATE products SET hoeveelheid = hoeveelheid - 1 WHERE id = $id");
                            } else {
                                echo "Product is niet op voorraad<br>";
                            }
                        }


                        $products = $_SESSION['producten'];
                        echo '<div class="grid grid-cols-1 gap-4 border border-black-600 p-5">';
                        foreach ($products as $key => $value) {
                            echo "<div class='border p-4 bg-gray-200'>" . $value['aantal'] . " x " . $value['name'] . "</div>";
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

        </body>

        </html>

        <?php
    } else {
        header('location:../home');
        exit;
    }
} else {
    header('location:../home');
    exit;
}
?>