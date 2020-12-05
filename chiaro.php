<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Chiaro</title>
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

            <?php echo "<h1>Welcome, $name!</h1>";
            }
            }
            ?>
        </nav>
    </header>
    <body>
        <main class="card-main">
              <div class="wrapper">
                  <div class="product-img">
                    <img src="./img/chiaro-card.png">
                  </div>
                  <div class="product-info">
                      <div class="product-text">
                          <h1>Chiaro and the Elixir of Life</h1>
                          <h2> VR game which won an NVIDIA Edge Program Prize for excellence in aesthetic achievement.</h2>
                          <p>Step into the role of Chiaro (voiced by Taylor Gray, Star Wars Rebels), a young engineer returning home to the forest of Neverain to build a machine called Boka and bring him to life with Elixir, a powerful ancient fuel. Together Boka and Chiaro form an unbreakable bond and embark on an epic adventure to find the lost Fountain of Elixir.</p>
                      </div>
                      <div class="product-price-btn">
                          <p><span>CDN$39.99</span></p>
                          <form action="https://store.steampowered.com/app/551440/Chiaro_and_the_Elixir_of_Life/" method="get" target="_blank">
                            <button type="submit">buy now</button>
                          </form>
                      </div>
                  </div>
              </div>
        </main>

<?php
require_once "./common/footer.php";
?>