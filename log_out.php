<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies enable?");
require_once "./common/functions_defs.php";
$title = "Log out";
require_once "./common/header.php";
?>

    <main class="logout-main">
        <?php

        if(isset($_SESSION["name"])) {
            $logged_user = "yes";
        }
        else{
            $logged_user = "";
        }

        session_unset();
        session_destroy();

        if ($logged_user){
            header("Refresh:0");
        }
        echo"<h1 class='login-h1'>You've been logged out!</h1>";
        ?>
    </main>

<?php
require_once "./common/footer.php";
?>

