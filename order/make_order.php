<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); //niet ingelogd ? -> login.php
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

//usr data ophalen
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM gebruikers WHERE id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    die("Gebruiker niet gevonden.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/make_order.css">
    <title>Bestelpagina</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('../get_products.php')
                .then(response => response.json())
                .then(data => {
                    const productSelect = document.getElementById('product');
                    data.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.productID;
                        option.textContent = product.naam;
                        productSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching products:', error));
        });
    </script>
</head>
<body>

<div class="bestel-form">
    <h2>Bestel een product</h2>
    <form action="submit_order.php" method="post">
        <div class="form-group">
            <label for="product">Selecteer een product:</label>
            <select id="product" name="product" required>
                <option value="">Kies een product...</option>
                
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Aantal:</label>
            <input type="number" id="quantity" name="quantity" min="1" required>
        </div>
        <div class="form-group">
            <label for="name">Naam:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['naam']); ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required readonly>
        </div>
        <div class="form-group">
            <button type="submit">Bestellen</button>
        </div>
    </form>
</div>
</body>
</html>
