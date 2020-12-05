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
                <li class="menu-item"><a href="index.php">HOME</a></li>
                <li class="menu-item"><a href="#">VR GAMES</a>
                    <ul class="submenu">
                        <li class="submenu-item"><a href="chiaro.php">CHIARO</a></li><br>
                        <li class="submenu-item"><a href="forged.php">FORGED</a></li>
                    </ul>
                </li>
                <li class="menu-item"><a href="#">ABOUT</a></li>
                <li class="menu-item"><a href="login.php">LOGIN
                        <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>
    <!--            <li class="menu-item"><a href="log_out.php">LOG OU</a></li>-->
    <!--                    <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>-->
    <!--            <li class="menu-item"><a href="shopping-cart.php">CART-->
    <!--                    <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>-->
    <!--            <li class="menu-item"><a href="admin_page.php">ADMIN-->
    <!--                    <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>-->
            </ul>
        </nav>
    </header>

<body class="vr-games-catalog-body">
    <main class="vr-games-catalog-main">
        <div id="images">

            <a href="chiaro.php">
                <table class="vr-games-catalog">
                <tr>
                    <th>Chiaro</th>
                </tr>
                <tr>
                    <td><img src="./img/chiaro-300x300.png" alt="Game Chiaro" style="width:300px;height:300px;"></td>
                </tr>
                <tr>
                    <td>CDN$39.99</td>
                </tr>
            </table></a>
            <a href="forged.php">
            <table class="vr-games-catalog">
                <tr>
                    <th>Forged</th>
                </tr>
                <tr>
                    <td><img src="img/forged-300x300.png" alt="Game Forged" style="width:300px;height:300px;"></td>
                </tr>
                <tr>
                    <td>CDN$59.99</td>
                </tr>
            </table></a>
            <a href="#">
            <table class="vr-games-catalog">
                <tr>
                    <th>Deka</th>
                </tr>
                <tr>
                    <td><img src="./img/deka-300x300.png" alt="Game Deka" style="width:300px;height:300px;"></td>
                </tr>
                <tr>
                    <td class="price">CDN$28.99</td>
                </tr>
            </table></a>
        </div>
    </main>

<?php
require_once "./common/footer.php";
?>


