<?php
require_once "./common/functions_defs.php";
require_once "./common/header.php";


// exception if the user entered spaces in name field
// trim removes white space at the beginning and at the end
if (empty(trim($_POST["name"]))) {
    echo "<h1 class = 'login'> No name provided</h1>";
} else {
    $name = clean_data($_POST["name"]); // clean_data avoids script or smth execution in the entering field
    echo "<h1 class = 'login h1' >Welcome, $name!</h1>";
}
require_once "./common/footer.php";