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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>login_test</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
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
                    <?php if($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_SESSION["name"])) {?>
                    <li class="menu-item"><a href="login.php">LOGIN
                            <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>

                            <?php } ?>

                    <?php if($_SESSION["name"] == "admin") {?>
                        <li class="menu-item"><a href="admin_page.php">ADMIN
                                <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>

                    <?php } ?>

                    <?php $name = $password = $hash = $name_error = $token_error = $login_error = "";
                    if($_SERVER["REQUEST_METHOD"] == "POST") {
                        if(!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
                            $token_error = "Error: Cannot process the form. CSRF tokens do not match.";
                        } elseif(empty($token_error)) {
                            validate_name($name, $name_error);
                            $password = clean_data($_POST["password"]);

                            /* read from db */
                            $conn = get_introdb_conn();
                            if ($conn->connect_error) {
                                $db_error = "Error: Connection failed " . $conn->connect_error;
                                $conn->close();
                            } else {

                                $hash = db_find_hash($conn, $name);
                                $conn->close();
                                if ($hash && password_verify($password, $hash)) {
                                    $_SESSION["name"] = $name;

//                          /* read from file */
//                          if(empty($name_error)) {
//                              $hash = find_hash($name);
//                              if ($hash && password_verify($password, $hash)){
//                                  $_SESSION["name"]=$name;
                                        ?>
                                        <li class="menu-item"><a href="log_out.php">LOG OUT<?php echo ", $name?"; ?></a></li>
                                        <li class="menu-item"><a href="shopping_cart.php">CART
                                                <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>

                                    <?php if($_SESSION["name"] == "admin") {?>

                                        <li class="menu-item"><a href="admin_page.php">ADMIN
                                                <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>

                                        <?php
                                            echo "<h1 class='login-h1'>Welcome back, $name!<br>Admin permissions are available</h1>";
                                        } ?>

                                        </ul>

                                        <?php
                                        if($_SESSION["name"] !== "admin") {
                                            echo "<h1 class='login-h1'>Welcome back, $name!<br>Now you can see your shopping cart</h1>";
                                        }
                                        print_r($_SESSION);
                                        }
                                else {
                                    $login_error = "Error: invalid username or password";
                                }
                            }
                        }
                    }

                elseif($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION["name"])) {
                        $get_name = $_SESSION["name"];
                ?>
                        <li class="menu-item"><a href="log_out.php">LOG OUT<?php echo ", $get_name?"; ?></a></li>
                        <li class="menu-item"><a href="shopping_cart.php">CART
                                <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>

                                </ul>

                        <?php echo "<h1 class='login-h1'>Welcome back, $get_name!<br>Now you can see your shopping cart</h1>";
                    }
                ?>
        </nav>

    <main class="login-main">

        <div class="login">


            <?php
                if ($name_error || $login_error || $token_error || ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_SESSION["name"]))) {
                    ?>

                <h1>Login</h1>

                <form action="login.php" method="post">
                    <input type="text" name="name" placeholder="Username" required="required" />
                    <input type="password" name="password" placeholder="Password" required="required" />
                    <button type="submit" class="btn btn-primary btn-block btn-large">Let me in!</button>
                    <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>"/>
                </form>

                    <form action="create_new_account.php">
                        <button type="submit" class="btn btn-primary btn-block btn-large">Register</button>
                    </form>
                    <span class="error"><?php echo $token_error, $name_error, $login_error; ?></span>
                    <?php
                }
                ?>

        </div>
    </main>


<?php
require_once "./common/footer.php";
?>