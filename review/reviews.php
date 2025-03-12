<?php
session_start();
require '../configs/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review'], $_POST['rating'])) {
    $user_id = $_SESSION['user_id'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, review, rating) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $review, $rating);
    if ($stmt->execute()) {
        echo "Review toegevoegd!";
    } else {
        echo "Fout bij toevoegen.";
    }
    $stmt->close();
}

$result = $conn->query("SELECT r.review, r.rating, g.naam FROM reviews r JOIN gebruikers g ON r.user_id = g.id");
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reviews</title>
</head>
<body>
    <h2>Laat een review achter</h2>
    <form method="POST">
        <textarea name="review" required></textarea>
        <label for="rating">Beoordeling (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required>
        <button type="submit">Verstuur</button>
    </form>
    <h2>Reviews van anderen</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li><strong><?php echo htmlspecialchars($row['naam']); ?>:</strong> <?php echo htmlspecialchars($row['review']) . " (" . $row['rating'] . "/5)"; ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
