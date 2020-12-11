<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
require_once "./common/functions_defs.php";
$title = "Home page";
require_once "./common/header.php";
?>

<iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fmartovco%2Fvideos%2F258668991422195%2F&autoplay=1&controls=0&modestbranding=1loop=1&playlist=video.php" width="100%" height="100%" style="border:none;overflow:hidden; z-index:-1; position:fixed;" scrolling="no" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowFullScreen="true" ></iframe>

<!-- Header -->
<header id="header" class="header">
    <div class="header-content">
        <div class="text-container">
            <h1>VR GAME, FANTASY, ARTSTYLE</h1>
            <p class="p-heading p-large">Martov Co is a virtual reality studio based in Montreal Canada.<br> Our first experience is an adventure game called 'Chiaro and The Elixir Of Life'.</p>
            <form action="vr_games.php">
                <a class="btn-solid-lg page-scroll" href="vr_games.php">VR GAMES</a>
            </form>
        </div>
    </div> <!-- end of header-content -->
</header> <!-- end of header -->
<!-- end of header -->

<?php
require_once "./common/footer.php";
?>

