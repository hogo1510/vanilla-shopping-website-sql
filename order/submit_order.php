<?php
session_start();

//check of ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html"); //niet ingelogd? -> login.html
    exit;
}

//verbinding db
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdev3";

$conn = new mysqli($servername, $username, $password, $dbname);

//check verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
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

//info formulier
$productID = $_POST['product'];
$quantity = $_POST['quantity'];
$naam = $user['naam'];
$email = $user['email'];

//logica van besteling
$sql = "INSERT INTO orders (productID, quantity, name, email) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $productID, $quantity, $naam, $email);

if ($stmt->execute()) {
    echo "Bedankt voor uw bestelling, $naam!";
    } else {
    echo "Er is een fout opgetreden bij het verwerken van uw bestelling. Probeer het opnieuw.";
}

//eindig verbinding
$stmt->close();
$conn->close();
?>
<br>
<a href="../loggedin.php" class="button">Ga terug</a>

