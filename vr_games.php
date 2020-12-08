<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
require_once "./common/functions_defs.php";
$title = "VR Games";
require_once "./common/header.php";
?>

    <main class="login-main vr-games-catalog-body">
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


