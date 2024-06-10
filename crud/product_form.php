<?php
session_start();

//errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

//check of ingelogs
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//verbinden db
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdev3";

$conn = new mysqli($servername, $username, $password, $dbname);

//check verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product = null;
if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];
    $sql = "SELECT * FROM product WHERE productID='$productID'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Toevoegen/Wijzigen</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2><?php echo $product ? "Product Wijzigen" : "Product Toevoegen"; ?></h2>
        <form action="save_product.php" method="post">
            <input type="hidden" name="productID" value="<?php echo $product ? $product['productID'] : ''; ?>">
            <div>
                <label for="type">Type</label>
                <select name="type" id="type">
                    <option value="bier" <?php echo $product && $product['type'] == 'bier' ? 'selected' : ''; ?>>Bier</option>
                    <option value="wijn" <?php echo $product && $product['type'] == 'wijn' ? 'selected' : ''; ?>>Wijn</option>
                </select>
            </div>
            <div>
                <label for="producent">Producent</label>
                <input type="text" id="producent" name="producent" value="<?php echo $product ? htmlspecialchars($product['producent']) : ''; ?>" required>
            </div>
            <div>
                <label for="naam">Naam</label>
                <input type="text" id="naam" name="naam" value="<?php echo $product ? htmlspecialchars($product['naam']) : ''; ?>" required>
            </div>
            <div>
                <label for="soort">Soort</label>
                <input type="text" id="soort" name="soort" value="<?php echo $product ? htmlspecialchars($product['soort']) : ''; ?>" required>
            </div>
            <div>
                <label for="land">Land</label>
                <input type="text" id="land" name="land" value="<?php echo $product ? htmlspecialchars($product['land']) : ''; ?>" required>
            </div>
            <div>
                <label for="prijs">Prijs</label>
                <input type="number" step="0.01" id="prijs" name="prijs" value="<?php echo $product ? htmlspecialchars($product['prijs']) : ''; ?>" required>
            </div>
            <div>
                <label for="voorraad">Voorraad</label>
                <input type="number" id="voorraad" name="voorraad" value="<?php echo $product ? htmlspecialchars($product['voorraad']) : ''; ?>" required>
            </div>
            <div>
                <button type="submit">Opslaan</button>
            </div>
        </form>
    </div>
</body>
</html>
