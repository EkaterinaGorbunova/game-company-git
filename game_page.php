<?php
session_start(['cookie_lifetime' => 24*60*60,]) or die("Cannot start the session. Are cookies  enable?");
if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(24));
}

require_once "./common/functions_defs.php";

$id = $_GET['id'];
//print_r($id);

$conn = get_introdb_conn();
if ($conn->connect_error) {
    die("Error: Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id, image, gamename, subtitle, description, price FROM vr_games WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $id = $image = $gamename = $title = $subtitle = $description = $price = "";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $col) {
            if ($col == $row['id']) {
                $id = $row['id'];
            }
            if ($col == $row['image']) {
                $image = $row['image'];
            }
            if ($col == $row['gamename']) {
                $gamename = $row['gamename'];
                $title = $row['gamename'];
            }
            if ($col == $row['subtitle']) {
                $subtitle = $row['subtitle'];
            }
            if ($col == $row['description']) {
                $description = $row['description'];
            }
            if ($col == $row['price']) {
                $price = $row['price'];
            }
        }
    }
}
require_once "./common/header.php";
?>


    <body>
        <main class="card-main">
              <div class="wrapper">
                  <div class="product-img">
                    <img src="<?php echo $image ?>">
                  </div>
                  <div class="product-info">
                      <div class="product-text">
                          <h1><?php echo $title ?></h1>
                          <h2><?php echo $subtitle ?></h2>
                          <p><?php echo $description ?></p>
                      </div>
                      <div class="product-price-btn">
                          <p><span>CDN$<?php echo $price ?></span></p>
                          <form action="https://store.steampowered.com/app/551440/Chiaro_and_the_Elixir_of_Life/" method="get" target="_blank">
                            <button type="submit">buy now</button>
                          </form>
                      </div>
                  </div>
              </div>
        </main>

<?php
require_once "./common/footer.php";
?>