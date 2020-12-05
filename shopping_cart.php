<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
require_once "./common/functions_defs.php";

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION["name"])) {
    $cart_username = $_SESSION["name"];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Shopping cart</title>
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
<!--                <li class="menu-item"><a href="log_out.php">LOG OUT</a></li>-->
                <li class="menu-item"><a href="log_out.php">LOG OUT<?php echo ", $cart_username?"; ?></a></li>
                <li class="menu-item"><a href="#">CART
                    <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>
            </ul>
        </nav>
   </header>
   <body>
       <main class="card-main">
           <div id="w">
               <header id="title">
                   <h1>Shopping Cart</h1>
               </header>
               <div id="page">
                   <table id="cart">

                       <thead>
                       <tr>
                           <th class="first">Photo</th>
                           <th class="second">Qty</th>
                           <th class="third">Product</th>
                           <th class="fourth">Line Total</th>
                           <th class="fifth">&nbsp;</th>
                       </tr>
                       </thead>

                       <tbody>
                       <!-- shopping cart contents -->
                       <tr class="productitm">
                           <td><img src="./img/chiaro-shopping-cart-122x57.png" class="thumb"></td>
                           <td><input type="number" value="1" min="0" max="99" class="qtyinput"></td>
                           <td>VR Game Chiaro</td>
                           <td>$39.99</td>
                           <td><span class="remove"><img src="https://i.imgur.com/h1ldGRr.png" alt="X"></span></td>
                       </tr>
                       <!-- items -->
                       <tr class="productitm">
                           <td><img src="./img/forged-shopping-cart-122x57.png" class="thumb"></td>
                           <td><input type="number" value="1" min="0" max="99" class="qtyinput"></td>
                           <td>VR Game Forged</td>
                           <td>$59.99</td>
                           <td><span class="remove"><img src="https://i.imgur.com/h1ldGRr.png" alt="X"></span></td>
                       </tr>

                       <!-- tax + subtotal -->
                       <tr class="extracosts">
                           <td class="light">Shipping &amp; Tax</td>
                           <td colspan="2" class="light"></td>
                           <td>$14.99</td>
                           <td>&nbsp;</td>
                       </tr>
                       <!-- total price -->
                       <tr class="totalprice">
                           <td class="light">Total:</td>
                           <td colspan="2">&nbsp;</td>
                           <td colspan="2"><span class="thick">$114.99</span></td>
                       </tr>

                       <!-- checkout btn -->
                       <tr class="checkoutrow">
                           <td colspan="5" class="checkout"><button id="submitbtn">Checkout Now!</button></td>
                       </tr>
                       </tbody>
                   </table>
               </div>
           </div>
       </main>

<?php
}

elseif ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_SESSION["name"])) {
    header ("Location: login.php");
}

require_once "./common/footer.php";
?>