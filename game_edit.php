<?php

session_start(['cookie_lifetime' => 24 * 60 * 60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
require_once "./common/functions_defs.php";
require_once "./common/header.php";
?>
<main class="login-main">

</main>

<?php
require_once "./common/footer.php";
?>
