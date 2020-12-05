<?php
require_once "./common/functions_defs.php";
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <nav class="nav">
            <img src="img/martov-transparent-background.png" width="250px" height="80px">
            <ul class="menu">
                <li class="menu-item"><a href="index.php">HOME</a></li>
                <li class="menu-item"><a href="vr_games_test.php">VR GAMES</a>
                    <ul class="submenu">
                        <li class="submenu-item"><a href="chiaro.php">CHIARO</a></li><br>
                        <li class="submenu-item"><a href="forged.php">FORGED</a></li>
                    </ul>
                </li>
                <li class="menu-item"><a href="#">ABOUT</a></li>
                <li class="menu-item"><a href="login.php">LOGIN
                        <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>

                <?php $name = ""; $name_error = "";
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                validate_name($name, $name_error);
                if(empty($name_error)) {?>
                <li class="menu-item"><a href="login.php">Log out<?php echo ", $name?"; ?></a></li>
                <li class="menu-item"><a href="shopping_cart.php">CART
                        <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>
            </ul>
            <?php echo "<h1 class='login-h1'>Welcome back, $name!<br>Now you can see your shopping cart</h1>";
            }
            }
            ?>
        </nav>

        <main class="login-main">

            <div class="login">


            <?php
                if ($name_error || $_SERVER["REQUEST_METHOD"] == "GET") {
                    ?>
                <h1>Login</h1>
                <form action="login.php" method="post">
                   <input type="text" name="name" placeholder="Username" required="required" />
                   <input type="password" name="p" placeholder="Password" required="required" />
                   <button type="submit" class="btn btn-primary btn-block btn-large">Let me in!</button>
                   <button type="submit" class="btn btn-primary btn-block btn-large">Create a new account</button>
                   <span class="error"><?php echo $name_error; ?></span>
                </form>
                   <?php
                }
                ?>
            </div>
        </main>

<?php
require_once "./common/footer.php";
?>
