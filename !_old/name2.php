<?php
$title = "Part B4 -- Simple name form";
require_once "./common/header.php";
?>

<form action="name_action2.php" method="post">
    <label>What is your name? <input type="text" name="name" required></label>
    <button type="submit">Send</button>
</form>


<?php
require_once "./common/footer.php";
?>
