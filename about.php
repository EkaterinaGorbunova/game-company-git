<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<header>
    <nav class="nav">
        <img src="img/martov-transparent-background.png" width="250px" height="80px">
        <ul class="menu">
            <li class="menu-item"><a href="index.php">HOME</a></li>
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

<main class="about-main">

    <h2>The standard Lorem Ipsum passage, used since the 1500s</h2>
        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

    <h2>Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC</h2>
        <p>"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</p>
</main>

<?php
require_once "./common/footer.php";
?>