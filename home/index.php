<?php
$error = false;
$errormessage = "";
if (isset($_POST['user'])) {

    session_start();

    $servername = "localhost";
    $username1 = "root";
    $password = "";
    $db = "kruidenhuis";

    $conn = new mysqli($servername, $username1, $password, $db);



    $username = $_POST['user'];

    $sql = "SELECT password FROM login WHERE username = '" . $username . "'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        $password = $_POST['password'];

        if ($password == $row['password']) {



            $sql = "SELECT admin FROM login WHERE username = '" . $username . "'";
            $result = mysqli_query($conn, $sql);

            $row = mysqli_fetch_assoc($result);

            $rights = $row['admin'];

            $_SESSION['login'] = $username;

            if ($rights == "1") {
                header("location:../beheer");
            } else if ($rights == "0") {
                header("location:../kassa");
            }

        } else {
            $errormessage = "Wachtwoord onjuist!";
            $error = true;
        }
    } else {
        $errormessage = "Gebruikersnaam niet gevonden!";
        $error = true;
    }




}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="w-screen h-screen bg-[#F6EACA] flex place-items-center justify-center gap-2 ">
        <form class="flex flex-col gap-5 p-4 bg-[#F0DB9E] w-75 rounded-xl shadow-xl" action="" method="POST">
            <?php if ($error): ?>
                <p class="flex justify-center"><?php echo $errormessage ?></p>
            <?php endif; ?>
            <p class="flex justify-center">Gebruikersnaam</p>
            <input class="bg-[#8D6E63] rounded-full px-3 py-2" type="text" name="user">
            <p class="flex justify-center">Wachtwoord</p>
            <input class="bg-[#8D6E63] rounded-full px-3 py-2" type="password" name="password">
            <input class="bg-[#8D6E63] rounded-full px-3 py-2" type="submit" name="submit" value="Login">
        </form>
    </div>
</body>

</html>