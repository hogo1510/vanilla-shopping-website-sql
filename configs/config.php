<?php
//TODO: alle bestande deze config laten gebruiken! (./configs)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdev3";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>
