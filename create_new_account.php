<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}
require_once "./common/functions_defs.php";
$title = "Registration";
require_once "./common/header.php";
?>

<?php
$username = $password1 = $password2 = $email = "";
$username_error = $password1_error = $password2_error = $email_error = $register_error = $token_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $password1 = clean_data($_POST["password1"]);
    $password2 = clean_data($_POST["password2"]);
    validate_username($username, $username_error);
    validate_email($email, $email_error);

    if(!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        $token_error = "Error: Cannot process the form. CSRF tokens do not match";
    }

    elseif (empty(trim($_POST["password1"]))) {
        $password1_error = "Error: no password provided";
    }
    elseif (empty(trim($_POST["password2"]))) {
        $password2_error = "Error: no password provided";
    }
    elseif ($password1 != $password2) {
        $register_error = "Error: The two passwords do not match";
    }

    elseif($username_error == "" && $password1_error == ""
        && $password2_error == "" && $email_error == "" && $token_error == "") {

        /* read from db */
        $conn = get_introdb_conn();
        if ($conn->connect_error) {
            $db_error = "Error: Connection failed " . $conn->connect_error;
            $conn->close();
        } else {
            $hash = db_find_hash($conn, $username);
            if ($hash) { // user already exist?
                $register_error = "This user name already exists!";
            } else {
                $options = ['cost' => 12,];
                $hash = password_hash($password1, PASSWORD_BCRYPT, $options);
                if (insert_user($conn, $username, $hash, $email)) {
                    $register_error = "Error: Can not create this user";
                } else {
                    ?>

                    <?php
                     echo "<h1 class='login-h1'>Congratulations $username,<br>you have successfully registered!<br></h1>";
                }
            }
        }
    }
}

?>

    <main class="login-main">
        <?php
        if ($username_error
        || $password1_error
        || $password2_error
        || $token_error
        || $register_error
        || ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_SESSION["username"]))) {
        ?>
        <div class="login">

            <h1>Registration</h1>

            <form action="create_new_account.php" method="post">
                <input type="text" name="username" placeholder="Username" required="required" />
                <input type="password" name="password1" placeholder="Password" required="required" />
                <input type="password" name="password2" placeholder="Enter password again" required="required" />
                <input type="email" name="email" placeholder="Enter your email" required="required" />
                <button type="submit" class="btn btn-primary btn-block btn-large">Register</button>
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>"/>
            </form>
                    <span class="error"><?php echo $username_error; ?></span>
                    <span class="error"><?php echo $password1_error; ?></span>
                    <span class="error"><?php echo $password2_error; ?></span>
                    <span class="error"><?php echo $register_error; ?></span>
                    <span class="error"><?php echo $token_error; ?></span>
            <?php
            }
            ?>
        </div>
    </main>
<?php
require_once "./common/footer.php";
?>