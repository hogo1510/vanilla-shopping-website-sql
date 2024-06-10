<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verbinding db
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "webdev3";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check conc
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    //query gebruiker
    $sql = "SELECT * FROM gebruikers WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($wachtwoord, $row['wachtwoord'])) {
            //Inloggen gelukt
            $_SESSION['user_id'] = $row['id'];
            header("Location: loggedin.php");
            exit;
        } else {
            $message = "Ongeldige e-mail of wachtwoord.";
        }
    } else {
        $message = "Ongeldige e-mail of wachtwoord.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="styles/register.css">
</head>
<body>
    <div class="container">
        <h2>Inloggen</h2>
        <?php if(isset($message)) { echo "<p>$message</p>"; } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="wachtwoord">Wachtwoord:</label>
                <input type="password" id="wachtwoord" name="wachtwoord" required>
            </div>
            <button type="submit">Inloggen</button>
            <a href="register.html" class="btn">registreren</a>
        </form>
    </div>
</body>
</html>
