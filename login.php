<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
require_once "./common/functions_defs.php";

$name = $password = $hash = $name_error = $token_error = $login_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        $token_error = "Error: Cannot process the form. CSRF tokens do not match.";
    } elseif (empty($token_error)) {
        validate_name($name, $name_error);
        $password = clean_data($_POST["password"]);

        /* read from db */
        $conn = get_introdb_conn();
        if ($conn->connect_error) {
            $db_error = "Error: Connection failed " . $conn->connect_error;
            $conn->close();
        } else {

            $hash = db_find_hash($conn, $name);
            $conn->close();
            if ($hash && password_verify($password, $hash)) {
                $_SESSION["name"] = $name;
            } else {
                $login_error = "Error: invalid username or password";
            }
        }
    }
}

$title = "Login";
require_once "./common/header.php";
?>

    <main class="login-main">

        <?php if(isset($_SESSION["name"]))
        {
            header("Location: index.php");
        } ?>

        <div class="login">


            <?php
                if ($name_error || $login_error || $token_error || ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_SESSION["name"]))) {
                    ?>

                <h1>Login</h1>

                <form action="login.php" method="post">
                    <input type="text" name="name" placeholder="Username" required="required" />
                    <input type="password" name="password" placeholder="Password" required="required" />
                    <button type="submit" class="btn btn-primary btn-block btn-large">Let me in!</button>
                    <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>"/>
                </form>

                    <form action="create_new_account.php">
                        <button type="submit" class="btn btn-primary btn-block btn-large">Register</button>
                    </form>
                    <span class="error"><?php echo $token_error, $name_error, $login_error; ?></span>
                    <?php
                }
                ?>
        </div>
    </main>

<?php
require_once "./common/footer.php";
?>