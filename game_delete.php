<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies enable?");
require_once "./common/functions_defs.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forged</title>
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
        <li class="menu-item"><a href="login.php">LOGIN
                <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>
        <li class="menu-item"><a href="shopping_cart.php">CART
                <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>
    </ul>
</nav>
<main class="logout-main">


<?php
//print_r($_POST['game_id']);
//print_r("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
//$id = $_GET['id'];

$game_delete_error = "";
$conn = get_introdb_conn();
if ($conn->connect_error) {
die("Error: Connection failed: " . $conn->connect_error);
}

$delete_game_id = $_POST['game_id'];
// delete a record

if (delete_game($conn, $delete_game_id)) {
//if ("true"){
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
require_once "./common/footer.php";
?>
