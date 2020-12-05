<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
if ($_SESSION["name"] == "admin") {

require_once "./common/functions_defs.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

<body class="admin-body">
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
            <li class="menu-item"><a href="log_out.php">LOG OUT</a></li>
            <li class="menu-item"><a href="shopping_cart.php">CART
                    <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>
            <li class="menu-item"><a href="admin_page.php">ADMIN
                    <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>

        </ul>
    </nav>
<main class="admin-main">
    <div align="center" style='padding-top: 20px'>
        <h2 style='color: white'>VR Games</h2>

        <?php
        $conn = get_introdb_conn();
        if ($conn->connect_error) {
            die("Error: Connection failed: " . $conn->connect_error);
        }
        if (empty($_GET["id"])) {
            $sql = "SELECT id, image, gamename, subtitle, description, price FROM vr_games";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<div><table class='table-games'><tr>";
                    foreach ($result->fetch_fields() as $field) {
                        echo "<th>{$field->name}</th>";
                    }
                    echo "<th>action</th>";
                    echo "</tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        $game_id = $row['id'];
                        foreach ($row as $col) {
                            if ($col == $row['image']) {
                                echo "<td><img src=$col></td>";
                            }
                            elseif ($col == $row['price']) {
                                echo "<td>CDN$$col</td>";
                            }
                            else {
                                echo "<td>$col</td>";
                            }
                        }
                        ?>
                        <form action="game_delete.php" method="post">
                            <?php echo "<td><input type='submit' value='Delete' name='delete_command'/>";?>

                            <?php echo "<input type='hidden' value=$game_id name='game_id'/>";?>
                        </form>
                        <form action="edit_game.php" method="post">
                            <?php echo "<input type='submit' value='Edit' name='edit_command'/></td>"; ?>
                        </form>
                        <?php echo "</tr>";
                    }
                    echo "</table></div>";
            } else {
                echo "0 result";
            }
        } else {
            // prepare the statement and bind the $id variable to the ?
            $stmt = $conn->prepare("SELECT id, image, gamename, subtitle, description, price FROM vr_games WHERE id = ?");
            $stmt->bind_param("i", $id);

            // assign a value to $id and execute the statement
            $id = clean_data($_GET["id"]);
            // the SQL statement has already been parsed, so no worries about the value to $
            // but it is better to clean the data anyway
            // without prepared statement, even after cleaning data, the query could be parsed
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
            // if you expect only 1 result, don't loop, just get the only row
            $row = $result->fetch_row();
            echo "<p><strong>ID</strong>: $row[0]</p>";
            echo "<p><strong>Image</strong>: $row[1]</p>";
            echo "<p><strong>Game name</strong>: $row[2]</p>";
            echo "<p><strong>Subtitle</strong>: $row[3]</p>";
            echo "<p><strong>Description</strong>: $row[4]</p>";
            echo "<p><strong>Price</strong>: $row[5]</p>";
            } else {
                echo "Game not found";
            }
        }
        $conn->close();
        ?>

    </div>

    <?php
        $gamename = $subtitle = $description = $price = $gamename_error = "";

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            validate_gamename($gamename, $gamename_error);
            if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
            $token_error = "Error: Cannot process the form. CSRF tokens do not match.";
            } elseif($gamename_error == "") {
            $target_dir = "./img/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Check if file already exists

            if (file_exists($target_file)) {
                echo "Error: This file already exists. Please, upload another. ";
                $uploadOk = 0;
            }
            // Check file size

            if ($_FILES["file"]["size"] > 1000000) {
                echo "Your file is too big. Please, try again. ";
                $uploadOk = 0;
            }

            // Allow certain file formats

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                echo "Only JPG, JPEG, PNG and GIF files are allowed. Please try again. ";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error

            if ($uploadOk == 0) {
                echo "Your file was not uploaded. ";
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
                } else {
                    echo "There was an error uploading your file. ";
                }
            }

            // Read from db

            $conn = get_introdb_conn();
            if ($conn->connect_error) {
                die("Error: Connection failed: " . $conn->connect_error);
            }   else {
                if (db_find_gamename($conn, $gamename)) { // game already exist?
                    $gamename_error = "Error: Game with this name already exists!";
                } else {
                    $subtitle = clean_data($_POST["subtitle"]);
                    $description = clean_data($_POST["description"]);
                    $price = clean_data($_POST["price"]);
                     if (insert_new_game($conn, $target_file, $gamename, $subtitle, $description, $price)) {
                         $game_error = "Error: Failed to add new game to DB";
                     } else {
                         header("Refresh:0");
                     }
                }
                $conn->close();

            }
        }
    }
    ?>

    <div  class="form-add-game-admin">
        <h2 style='color: white' align="center">Add new VR game</h2>

        <form enctype="multipart/form-data" action="admin_page.php" method="post">
            <h4>gamename:</h4> <input class="form-add-game-admin input" type="text" name="gamename" maxlength=50 required="required" />
            <h4>subtitle:</h4>
            <textarea rows="5" cols="50" maxlength='150' name="subtitle" required="required" placeholder="Please, type your subtitle here..."></textarea>
            <h4>description:</h4>
            <textarea rows="5" cols="50" maxlength='430' name="description" required="required" placeholder="Please, type your description here..."></textarea>
            <h4>price</h4><input type="text" name="price" maxlength=20 required="required">

            <label for="file">Select file to upload :</label><br />
            <input name="file" required="required" type="file" id="file"/><br /><br />

            <button type="submit" class="btn btn-primary btn-large">Add a new game</button>
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>"/>
        </form>

        <span class="error"><?php echo $gamename_error; ?></span>
        <span class="error"><?php echo $token_error; ?></span>
    </div>
</main>

<?php
require_once "./common/footer.php";
?>

<?php }
?>