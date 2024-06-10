<?php
session_start();

//erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

//check of ingelogd
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

//info formulier
$productID = isset($_POST['productID']) ? $_POST['productID'] : null;
$type = $_POST['type'];
$producent = $_POST['producent'];
$naam = $_POST['naam'];
$soort = $_POST['soort'];
$land = $_POST['land'];
$prijs = $_POST['prijs'];
$voorraad = $_POST['voorraad'];

if ($productID) {
    //update product
    $sql = "UPDATE product SET type='$type', producent='$producent', naam='$naam', soort='$soort', land='$land', prijs='$prijs', voorraad='$voorraad' WHERE productID='$productID'";
} else {
    //nieuwe toevoegen
    $sql = "INSERT INTO product (type, producent, naam, soort, land, prijs, voorraad) VALUES ('$type', '$producent', '$naam', '$soort', '$land', '$prijs', '$voorraad')";
}

if ($conn->query($sql) === TRUE) {
    header("Location: product_list.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
