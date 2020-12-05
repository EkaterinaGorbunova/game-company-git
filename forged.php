<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Forged</title>
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
						<li class="submenu-item"><a href="#">FORGED</a></li>
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
				  <img src="./img/forged-card.png">
				</div>
				<div class="product-info">
                    <div class="product-text">
                        <h1>Forged</h1>
                        <h2>Forged is a first-person virtual reality adventure game</h2>
                        <p>The wonderful story about a strong woman, Qadira, who fights with evil creatures from Dekar. She has devoted her life to fight back the Blossom of Omara, a sinister influence pouring from a rift between worlds that corrupts everything it touches.</p>
                    </div>
                    <div class="product-price-btn">
                      <p><span>CDN$59.99</span></p>
                      <button type="button">buy now</button>
                    </div>
				</div>
			</div>
		</main>

<?php
require_once "./common/footer.php";
?>