<?php
require_once '../config/db.php';
include 'header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style='color:red;'>Invalid job ID.</p>";
    include 'footer.php';
    exit();
}

$job_id = (int) $_GET['id'];
$stmt = $conn->prepare("
    SELECT j.title, j.description, j.location, j.salary, j.created_at, u.name AS employer
    FROM jobs j
    JOIN users u ON j.employer_id = u.id
    WHERE j.id = ?
");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($job = $result->fetch_assoc()) {
    echo "<h2>" . htmlspecialchars($job['title']) . "</h2>";
    echo "<p><strong>Posted by:</strong> " . htmlspecialchars($job['employer']) . "</p>";
    echo "<p><strong>Location:</strong> " . htmlspecialchars($job['location']) . "</p>";
    echo "<p><strong>Salary:</strong> " . htmlspecialchars($job['salary']) . "</p>";
    echo "<p><strong>Posted on:</strong> " . date("F j, Y", strtotime($job['created_at'])) . "</p>";
    echo "<hr><p>" . nl2br(htmlspecialchars($job['description'])) . "</p>";
} else {
    echo "<p>Job not found.</p>";
}

$stmt->close();
include 'footer.php';
?>
