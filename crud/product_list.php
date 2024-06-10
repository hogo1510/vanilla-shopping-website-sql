<?php
session_start();

//errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

//check ingelogs
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

$sql = "SELECT * FROM product";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Lijst</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Product Lijst</h2>
        <a href="product_form.php">Nieuw Product Toevoegen</a>
        <?php if (!empty($products)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Producent</th>
                        <th>Naam</th>
                        <th>Soort</th>
                        <th>Land</th>
                        <th>Prijs</th>
                        <th>Voorraad</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['productID']); ?></td>
                            <td><?php echo htmlspecialchars($product['type']); ?></td>
                            <td><?php echo htmlspecialchars($product['producent']); ?></td>
                            <td><?php echo htmlspecialchars($product['naam']); ?></td>
                            <td><?php echo htmlspecialchars($product['soort']); ?></td>
                            <td><?php echo htmlspecialchars($product['land']); ?></td>
                            <td><?php echo htmlspecialchars($product['prijs']); ?></td>
                            <td><?php echo htmlspecialchars($product['voorraad']); ?></td>
                            <td>
                                <a href="product_form.php?productID=<?php echo $product['productID']; ?>">Bewerken</a>
                                <a href="delete_product.php?productID=<?php echo $product['productID']; ?>" onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?')">Verwijderen</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Geen producten gevonden.</p>
        <?php endif; ?>
    </div>
</body>
</html>
