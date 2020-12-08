<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
require_once "./common/functions_defs.php";
$title = "Delete game";
require_once "./common/header.php";
if ($_SESSION["name"] == "admin") {
    ?>

    <main class="logout-main">
        <?php
        $game_delete_error = "";
        $conn = get_introdb_conn();
        if ($conn->connect_error) {
            die("Error: Connection failed: " . $conn->connect_error);
        }

        $delete_game_id = $_POST['game_id'];

        // delete a record

        if (delete_game($conn, $delete_game_id)) {
            $game_delete_error = "Error: Failed to delete game from DB";
            ?><span class="error"><?php echo $game_delete_error; ?></span><?php
        }
        else {
            header("Location: admin_page.php");
        }

        $conn->close();
        ?>
    </main>

    <?php
}
require_once "./common/footer.php";
?>
