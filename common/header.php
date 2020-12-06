<?php
if (!isset($title))
    $title = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!--    <header>-->
        <nav class="nav">
            <img src="./img/martov-transparent-background.png" width="250px" height="80px">
            <ul class="menu">
                <li class="menu-item"><a href="index.php">HOME</a></li>
                <li class="menu-item"><a href="vr_games.php">VR GAMES</a>
                    <ul class="submenu">
                    <?php
                    $conn = get_introdb_conn();
                    if ($conn->connect_error) {
                        die("Error: Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT id, gamename FROM vr_games";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            foreach ($row as $col) {
                                if ($col == $row['id']) {
                                    $submenu_id = $row['id'];
                                }
                                if ($col == $row['gamename']) {
                                    $submenu_gamename = $row['gamename'];
                                }
                            }
                            echo "<li class='submenu-item'><a href='game_page.php?id=$submenu_id'>$submenu_gamename</a></li><br>";
                        }
                    }
                    $conn->close();
                    ?>
                    </ul>
                </li>
                <li class="menu-item"><a href="about.php">ABOUT</a></li>
                <?php if (!isset($_SESSION["name"])) {?>
                    <li class="menu-item"><a href="login.php">LOGIN
                            <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>
                <?php } ?>
                <?php if (isset($_SESSION["name"])) {?>
                    <li class="menu-item"><a href="shopping_cart.php">CART
                            <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>
                <?php } ?>
                <?php if ($_SESSION["name"] == "admin") {?>
                    <li class="menu-item"><a href="admin_page.php">ADMIN
                            <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>
                <?php } ?>
                <?php if (isset($_SESSION["name"])) {?>
                    <li class="menu-item"><a href="log_out.php">LOG OUT, <?php echo $_SESSION["name"];?>?</a></li>
                <?php } ?>

        </nav>
<!--    </header>-->
