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
    <title>Forged</title>
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
        <li class="menu-item"><a href="login_test.php">LOGIN
                <i class="fa fa-fw fa-user" style="font-size:18px"></i></a></li>
        <li class="menu-item"><a href="shopping_cart.php">CART
                <i class="fa fa-shopping-cart" style="font-size:18px"></i></a></li>
    </ul>
</nav>
<main class="logout-main">

    <?php

$target_dir = "./uploaded_files/";

$target_file = $target_dir . basename($_FILES["file"]["name"]);

$uploadOk = 1;

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image is real or fake

if(isset($_POST["submit"])) {

    $check = getimagesize($_FILES["file"]["tmp_name"]);

    if($check !== false) {

        echo "File is an image - " . $check["mime"] . ".";

        $uploadOk = 1;

    } else {

        echo "Error: This is not an image file. Please, upload another. ";

        $uploadOk = 0;

    }

}

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

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"

    && $imageFileType != "gif" ) {

    echo "Only JPG, JPEG, PNG and GIF files are allowed. Please try again. ";

    $uploadOk = 0;

}

// Check if $uploadOk is set to 0 by an error

if ($uploadOk == 0) {

    echo "Your file was not uploaded. ";

} else {

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";

    } else {

        echo "There was an error uploading your file. ";

    }

}
?>
</main>
<?php
require_once "./common/footer.php";
?>

