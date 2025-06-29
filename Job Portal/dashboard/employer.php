<?php include 'header.php'; ?>
<?php
if ($_SESSION['user_type'] !== 'employer') {
    echo "<p style='color:red;'>Only Employers can access this page.</p>";
    include 'footer.php';
    exit();
}

require_once '../config/db.php';
?>

<h2>Employer Dashboard</h2>

<h3>Post a New Job</h3>
<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" required></textarea><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" required><br><br>

    <label>Salary:</label><br>
    <input type="text" name="salary" required><br><br>

    <button type="submit">Post Job</button>
</form>

<?php
// Job posting handler
if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $loc = trim($_POST['location']);
    $sal = trim($_POST['salary']);

    if (!preg_match("/^[a-zA-Z0-9\s,.-]{2,150}$/", $title)) {
        echo "<p style='color:red;'>Invalid title format.</p>";
    } elseif (!preg_match("/^[a-zA-Z0-9\s,.-]{2,100}$/", $loc)) {
        echo "<p style='color:red;'>Invalid location format.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO jobs (employer_id, title, description, location, salary) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $_SESSION['user_id'], $title, $desc, $loc, $sal);
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Job posted successfully.</p>";
        } else {
            echo "<p style='color:red;'>Error posting job.</p>";
        }
        $stmt->close();
    }
}
?>

<hr>

<h3>Your Posted Jobs</h3>
<?php
$stmt = $conn->prepare("SELECT id, title, created_at FROM jobs WHERE employer_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$jobs = $stmt->get_result();

while ($job = $jobs->fetch_assoc()) {
    echo "<p><strong>".htmlspecialchars($job['title'])."</strong> <br>";
    echo "Posted on: " . date("F j, Y", strtotime($job['created_at'])) . "<br>";

    // Count applicants
    $job_id = $job['id'];
    $app_stmt = $conn->prepare("SELECT COUNT(*) FROM applications WHERE job_id = ?");
    $app_stmt->bind_param("i", $job_id);
    $app_stmt->execute();
    $app_stmt->bind_result($app_count);
    $app_stmt->fetch();
    $app_stmt->close();

    echo "Applicants: $app_count<br><br>";
    echo '<a href="job_applicants.php?job_id=' . $job['id'] . '">View Details</a></p><hr>';

}

$stmt->close();
?>

<?php include 'footer.php'; ?>
