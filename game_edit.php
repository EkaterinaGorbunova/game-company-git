<?php

session_start(['cookie_lifetime' => 24 * 60 * 60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}

require_once "./common/functions_defs.php";

$id = $_POST['game_id'];
//print_r("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
//print_r($id);

$conn = get_introdb_conn();
if ($conn->connect_error) {
    die("Error: Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT id, image, gamename, subtitle, description, price FROM vr_games WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
//print_r($result);
if ($result->num_rows > 0) {

$image = $gamename = $title = $subtitle = $description = $price = "";
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $col) {
            if ($col == $row['image']) {
                $image = $row['image'];
            }
            if ($col == $row['gamename']) {
                $gamename = $row['gamename'];
//                print_r($gamename);
            }
            if ($col == $row['subtitle']) {
                $subtitle = $row['subtitle'];
            }
            if ($col == $row['description']) {
                $description = $row['description'];
            }
            if ($col == $row['price']) {
                $price = $row['price'];
            }
        }
    }
}
$title = "Edit game - $gamename";
require_once "./common/header.php";
?>



<?php
if (isset($_POST['updating_game'])) {
//    $gamename = $subtitle = $description = $price = $gamename_error = $reload_page = "";
    $gamename_error = $reload_page = "";
    $size_error = $extension_error = $upload_error = $game_update_error = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        validate_gamename($gamename, $gamename_error);
        if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
            $token_error = "Error: Cannot process the form. CSRF tokens do not match.";
        } elseif ($gamename_error == "") {
            $target_dir = "./img/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Check if file already exists

//                if (file_exists($target_file)) {
//                    echo "Error: This file already exists. Please, upload another. ";
//                    $uploadOk = 0;
//                }
            // Check file size

            if ($_FILES["file"]["size"] > 10000000) {
                $size_error = "Your file is too big. Please, try again.";
//                    echo "Your file is too big. Please, try again.";
                $uploadOk = 0;
            }

            // Allow certain file formats

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $extension_error = "Only JPG, JPEG, PNG and GIF files are allowed. Please try again.";
//                    echo "Only JPG, JPEG, PNG and GIF files are allowed. Please try again.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error

            if ($uploadOk == 0) {
//                    echo "Your file was not uploaded due to above error. New game was not added.";
                $upload_error = "Your file was not uploaded due to above error. New game was not added.";
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";

                    // Read from db
                    $conn = get_introdb_conn();
                    if ($conn->connect_error) {
                        die("Error: Connection failed: " . $conn->connect_error);
                    } else {
                        if (db_find_gamename($conn, $gamename)) { // game already exist?
                            $gamename_error = "Error: Game with this name already exists!";
                        } else {
                            $subtitle = clean_data($_POST["subtitle"]);
                            $description = clean_data($_POST["description"]);
                            $price = clean_data($_POST["price"]);

                            if (update_game($conn, $id, $target_file, $gamename, $subtitle, $description, $price )) {
                                $game_update_error = "Error: Game was not updated.";
                            }



//                            if (delete_game($conn, $id)) {
//                                $game_delete_error = "Error: Failed to delete game from DB";
//                                ?><!--<span class="error">--><?php //echo $game_delete_error; ?><!--</span>--><?php
//                            }
//                            else {
//                                if (insert_new_game($conn, $target_file, $gamename, $subtitle, $description, $price)) {
//                                    $game_error = "Error: Failed to add new game to DB.";
//                                    //                                    echo "Error: Failed to add new game to DB.\n";
//                                } else {
//                                    //                                    echo"REFRESHING PAGE....";
//                                    //                                    header("Refresh:0");
//                                    $reload_page = "yes";
//                                    //                                    header("Refresh:0; url=admin_page.php");
//                                    //                                    header("Location: admin_page.php");
//                                }
//                            }

                        }
                        $conn->close();
                        if ($reload_page) {
                            echo "<meta http-equiv=\"refresh\" content=\"0;URL=admin_page.php\">";
                        }

                    }

                } else {
                    echo "There was an error uploading your file. New game was not added.";
                }
            }


        }
    }
}
?>





<main class="login-main">

<?php if (!isset($_POST['updating_game'])) { ?>
    <div  class="form-add-game-admin">
        <h2 style='color: white' align="center">Editing game <?php echo $gamename ?></h2>

        <form enctype="multipart/form-data" action="game_edit.php" method="post">
            <h4>gamename:</h4><input class="form-add-game-admin input" type="text" name="gamename" maxlength=50 required="required" value=<?php echo $gamename ?> >
            <h4>subtitle:</h4>
            <textarea rows="5" cols="50" maxlength='150' name="subtitle" required="required"> <?php echo $subtitle ?> </textarea>
            <h4>description:</h4>
            <textarea rows="5" cols="50" maxlength='430' name="description" required="required"> <?php echo $description ?> </textarea>
            <h4>price</h4><input type="text" name="price" maxlength=20 required="required" value=<?php echo $price ?> >

            <label for="file">Select file to upload :</label><br />
            <input name="file" required="required" type="file" id="file"/><br /><br />

            <button type="submit" class="btn btn-primary btn-large">Add a new game</button>
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>"/>
            <input type="hidden" name="updating_game" value="yes"/>
        </form>
    </div>

    <div align="center">

    <?php } ?>

        <?php
        if ($gamename_error) { ?>
            <span class="error"><?php echo $gamename_error; ?></span><br>
            <?php
        }
        ?>

        <?php
        if ($token_error) { ?>
            <span class="error"><?php echo $token_error; ?></span><br>
            <?php
        }
        ?>

        <?php
        if ($size_error) { ?>
            <span class="error"><?php echo $size_error; ?></span><br>
            <?php
        }
        ?>

        <?php
        if ($extension_error) { ?>
            <span class="error"><?php echo $extension_error; ?></span><br>
            <?php
        }
        ?>

        <?php
        if ($upload_error) { ?>
            <span class="error"><?php echo $upload_error; ?></span><br>
            <?php
        }
        ?>

        <?php
        if ($game_update_error) { ?>
            <span class="error"><?php echo $game_update_error; ?></span><br>
            <?php
        }
        ?>



    </div>

</main>

<?php
require_once "./common/footer.php";
?>
