<?php include 'header.php'; ?>
<?php
if ($_SESSION['user_type'] !== 'seeker') {
    echo "<p style='color:red;'>Only Job Seekers can access Job Alerts.</p>";
    include 'footer.php';
    exit();
}

// Handle DB connection
require_once '../config/db.php';

// Insert alert
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['keyword'])) {
    $keyword = trim($_POST['keyword']);

    if (!preg_match("/^[a-zA-Z0-9,\s]{2,100}$/", $keyword)) {
        echo "<p style='color:red;'>Invalid keyword format.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO job_alerts (user_id, keywords) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION['user_id'], $keyword);
        $stmt->execute();
        $stmt->close();
    }
}

// Delete alert
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM job_alerts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

// Fetch alerts
$stmt = $conn->prepare("SELECT id, keywords FROM job_alerts WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$alerts = $stmt->get_result();
?>

<h2>Job Alerts</h2>

<form method="POST">
    <label>Keyword:</label>
    <input type="text" name="keyword" required>
    <button type="submit">Add Alert</button>
</form>

<h3>My Alerts:</h3>
<ul>
    <?php while ($row = $alerts->fetch_assoc()): ?>
        <li>
            <?php echo htmlspecialchars($row['keywords']); ?>
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this alert?')">❌</a>
        </li>
    <?php endwhile; ?>
</ul>

<?php
// Show job matches
echo "<h3>Matching Jobs:</h3>";

foreach ($alerts as $alert) {
    $keyword = "%" . $alert['keywords'] . "%";
    $stmt = $conn->prepare("SELECT id, title, description FROM jobs WHERE title LIKE ? OR description LIKE ?");
    $stmt->bind_param("ss", $keyword, $keyword);
    $stmt->execute();
    $results = $stmt->get_result();

    while ($job = $results->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($job['title']) . "</strong><br>";
        echo htmlspecialchars(substr($job['description'], 0, 100)) . "...</p>";
        echo '<a href="job_view.php?id=' . $job['id'] . '">View Full Details</a><hr>';
    }

    $stmt->close();
}
?>

<?php include 'footer.php'; ?>
