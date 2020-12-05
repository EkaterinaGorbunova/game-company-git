<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
require_once "./common/functions_defs.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Martov Co</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <header>
        <nav class="nav">
            <img src="img/martov-transparent-background.png" width="250px" height="80px">
            <ul class="menu">
                <li class="menu-item"><a href="#">HOME</a></li>
                <li class="menu-item"><a href="vr_games.php">VR GAMES</a>
                    <ul class="submenu">
                        <li class="submenu-item"><a href="chiaro.php">CHIARO</a></li><br>
                        <li class="submenu-item"><a href="forged.php">FORGED</a></li>
                    </ul>
                </li>
                <li class="menu-item"><a href="#">ABOUT</a></li>
                <li class="menu-item"><a href="login.php">LOGIN
                        <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>
                <?php $name_error = "";
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty(trim($_POST["name"]))) {
                    $name_error = "Error: no name provided";
                } else {
                    $name = clean_data($_POST["name"]);
                ?>
                <li class="menu-item"><a href="shopping_cart.php">CART
                        <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>
            </ul>

            <?php
            }
            }
            ?>
        </nav>
    </header>

<body>

    <main class="index-main">

    </main>

<?php
require_once "./common/footer.php";
?>

