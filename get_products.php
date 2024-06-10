<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdev3";

//verbinding db
$conn = new mysqli($servername, $username, $password, $dbname);

//check verbinding db
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

//producetn ophalen
$sql = "SELECT productID, naam FROM product";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$conn->close();

echo json_encode($products);
?>
