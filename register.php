<?php
//Check POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

error_reporting(E_ALL);
ini_set('display_errors', 1);
    //Verbinding db
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webdev3";

    $conn = new mysqli($servername, $username, $password, $dbname);

    //Check verbinding
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    //WW Hashen
    $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);

    //query gebruiker toevoegen
    $sql = "INSERT INTO gebruikers (naam, email, wachtwoord) VALUES ('$naam', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registratie succesvol!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    //geen POST?
    $message = "Moet via een HTTP POST-verzoek :)";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie</title>
    <link rel="stylesheet" href="styles/register.css">
</head>
<body>
    <div class="container">
        <h2>Registratie</h2>
        <p><?php echo $message; ?></p>
        <a href="register.html">Terug naar registratiepagina</a> <br>
        <a href="login.html">Ga naar inlogpagina</a>
    </div>
</body>
</html>
