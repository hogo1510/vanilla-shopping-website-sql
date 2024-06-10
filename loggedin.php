<?php
session_start();

//foutmeldingen
error_reporting(E_ALL);
ini_set('display_errors', 1);

//check of ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); //niet ingelogd? -> login.php
    exit;
}

//verbinding db
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdev3";

$conn = new mysqli($servername, $username, $password, $dbname);

// dubbel check verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//usr data ophalen
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM gebruikers WHERE id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    die("Gebruiker niet gevonden.");
}

// Bestellingen usr ophalen
$sql_orders = "SELECT o.orderID, o.productID, o.quantity, o.orderDate, p.naam as product_naam 
               FROM orders o
               JOIN product p ON o.productID = p.productID
               WHERE o.name = '".$user['naam']."' AND o.email = '".$user['email']."'";
$result_orders = $conn->query($sql_orders);

$orders = [];
if ($result_orders->num_rows > 0) {
    while($row = $result_orders->fetch_assoc()) {
        $orders[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<center>
    <div class="container">
        <h2>Accountgegevens</h2> <hr>
        <p><strong>Naam:</strong> <?php echo htmlspecialchars($user['naam']); ?></p>
        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <hr><h2>Uw Bestellingen</h2>
        <?php if (!empty($orders)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Bestelnummer</th>
                        <th>Product</th>
                        <th>Aantal</th>
                        <th>Besteldatum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['orderID']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_naam']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($order['orderDate']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>U heeft nog geen bestellingen geplaatst.</p>
        <?php endif; ?>
    </div>
<br>
        <a href="order/make_order.php">Bestel</a>
        <a href="crud/product_list.php">change-product</a>
        <a href="logout.php">Uitloggen</a>
</center>
</body>
</html>

