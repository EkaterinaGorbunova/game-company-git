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
    <title>create_new_account</title>
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
//                    $username = clean_data($_POST["username"]);

                    /* read from db */
                    $conn = get_introdb_conn();
                    if ($conn->connect_error) {
                        $db_error = "Error: Connection failed " . $conn->connect_error;
                        $conn->close();
                    } else {
                        print_r("Error: Connection established without errors");
                        $hash = db_find_hash($conn, $username);
                        if ($hash) { // user already exist?
                            $register_error = "This user name already exists!";
                        } else {
                            print_r("Error: No existing hash found");
                            $options = ['cost' => 12,];
                            $hash = password_hash($password1, PASSWORD_BCRYPT, $options);
                            if (insert_user($conn, $username, $hash, $email)) {
                                $register_error = "Error: Can not create this user";
                                print_r("Error: insert_user returned error");
                            } else {
                                print_r("Error: insert_user did not receive any error");
                                ?>
                                </ul>
                                <?php
                                 echo "<h1 class='login-h1'>Congratulations $username,<br>you have successfully registered!<br></h1>";
                                print_r($_SESSION);
                            }
                        }
                    }
                }
            }
                                /* read from file */
//                    $hash = find_hash($username);
//                    if ($hash) { // user already exist?
//                        $register_error = "This user name already exists!";
//                    } else {
//                        $options = ['cost' => 12,];
//                        $hash = password_hash($password1, PASSWORD_BCRYPT, $options);
//
//                        $passwords_file = fopen("passwords.csv", "a") or die ("Adding_user - unable to open file passwords.csv!");
//                        fputcsv($passwords_file, array($username, $hash, $email));
//                        fclose($passwords_file);
//
//
//                    ?>
<!---->
<!--                    </ul>-->
<!---->
<!--                    --><?php //echo "<h1 class='login-h1'>Congratulations $username,<br>you have successfully registered!<br></h1>";
//                    print_r($_SESSION);
//                    }

        ?>
    </nav>
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
            print_r($_SESSION);
            }
            ?>
        </div>
    </main>
<?php
require_once "./common/footer.php";
?>