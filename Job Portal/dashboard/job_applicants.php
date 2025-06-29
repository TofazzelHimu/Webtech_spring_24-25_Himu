<?php
include 'header.php';
require_once '../config/db.php';

if ($_SESSION['user_type'] !== 'employer') {
    echo "<p style='color:red;'>Access denied.</p>";
    include 'footer.php';
    exit();
}

if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
    echo "<p>Invalid Job ID.</p>";
    include 'footer.php';
    exit();
}

$job_id = (int) $_GET['job_id'];

// Fetch job info
$stmt = $conn->prepare("SELECT title, description, location, salary, created_at FROM jobs WHERE id = ? AND employer_id = ?");
$stmt->bind_param("ii", $job_id, $_SESSION['user_id']);
$stmt->execute();
$job_result = $stmt->get_result();

if ($job = $job_result->fetch_assoc()) {
    echo "<h2>" . htmlspecialchars($job['title']) . "</h2>";
    echo "<p><strong>Description:</strong><br>" . nl2br(htmlspecialchars($job['description'])) . "</p>";
    echo "<p><strong>Location:</strong> " . htmlspecialchars($job['location']) . "</p>";
    echo "<p><strong>Salary:</strong> " . htmlspecialchars($job['salary']) . "</p>";
    echo "<p><strong>Posted on:</strong> " . date("F j, Y", strtotime($job['created_at'])) . "</p><hr>";

    $app_stmt = $conn->prepare("
        SELECT 
            u.id AS seeker_id,
            u.name,
            u.email,
            a.status,
            a.applied_at,
            (
                SELECT r.filepath
                FROM resumes r
                WHERE r.user_id = u.id
                ORDER BY r.created_at DESC
                LIMIT 1
            ) AS resume_path
        FROM applications a
        JOIN users u ON a.seeker_id = u.id
        WHERE a.job_id = ?
    ");

    $app_stmt->bind_param("i", $job_id);
    $app_stmt->execute();
    $applicants = $app_stmt->get_result();

    // WHY IS THIS SO frustatinwfwoenfwefDAWIDBAWDAWBDW
    echo "<h3>Applicants:</h3>";
    if ($applicants->num_rows === 0) {
        echo "<p>No applicants for this job.</p>";
    } else {
        while ($row = $applicants->fetch_assoc()) {
            echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong> (" . htmlspecialchars($row['email']) . ")<br>";
            echo "Status: " . htmlspecialchars($row['status']) . "<br>";
            echo "Applied on: " . date("F j, Y", strtotime($row['applied_at'])) . "<br>";

            $safe_path = htmlspecialchars($row['resume_path']);
            if (!empty($row['resume_path']) && file_exists('../' . $safe_path)) {
                echo '<a href="../' . $safe_path . '" target="_blank">View Resume</a>';
            } else {
                echo "<em>No resume uploaded.</em>";
            }

            echo "</p><hr>";
        }
    }

    $app_stmt->close();
} else {
    echo "<p>Job not found or access denied.</p>";
}
$stmt->close();

include 'footer.php';
?>
