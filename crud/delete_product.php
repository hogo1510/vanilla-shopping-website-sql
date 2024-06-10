<?php
session_start();

// Foutmeldingen inschakelen
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdev3";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleren op verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];
    $sql = "DELETE FROM product WHERE productID='$productID'";
    if ($conn->query($sql) === TRUE) {
        header("Location: product_list.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Geen productID opgegeven.";
}

$conn->close();
?>
