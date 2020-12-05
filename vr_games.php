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
        </ul>
    </nav>
</header>

<body class="vr-games-catalog-body">
<main class="vr-games-catalog-main">
    <div id="images">

        <?php
        $conn = get_introdb_conn();
        if ($conn->connect_error) {
            die("Error: Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, image, gamename, subtitle, description, price FROM vr_games";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {


            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $col) {
                    if ($col == $row['id']) {
                        $id = $row['id'];
                    }
                    if ($col == $row['image']) {
                        $image = $row['image'];
                    }
                    if ($col == $row['gamename']) {
                        $gamename = $row['gamename'];
                    }
                    if ($col == $row['price']) {
                        $price = $row['price'];
                    }
                }
                ?>
                <a href="game_page.php?id=<?php echo $id; ?>">
        <?php
/*  example:          <a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>      */
                echo "<table class='vr-games-catalog'>";
                echo "<tr>";
                echo "<th>$gamename</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><img src=$image alt='Game Chiaro' style='width:300px;height:300px;'></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>CDN$$price</td>";
                echo "</tr>";
                echo "</table></a>";
            }
        }
        ?>

    </div>
</main>

<?php
require_once "./common/footer.php";
?>


