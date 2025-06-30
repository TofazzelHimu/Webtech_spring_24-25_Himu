<?php
include('header.php');
include('../config/db.php');

$user_id = $_SESSION['user_id'];
$message = '';

// Delete resume if requested
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    $stmt = $conn->prepare("SELECT filepath FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($filepath);

    if ($stmt->fetch()) {
        if (file_exists($filepath)) {
            unlink($filepath); // delete file from storage
        }
        $stmt->close();

        $del = $conn->prepare("DELETE FROM resumes WHERE id = ? AND user_id = ?");
        $del->bind_param("ii", $delete_id, $user_id);
        $del->execute();
        $del->close();

        $message = "Resume deleted.";
    } else {
        $message = "Resume not found.";
    }
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filename = $_FILES['resume']['name'];
    $tempname = $_FILES['resume']['tmp_name'];
    $folder = "../uploads/resumes/" . $filename;

    $allowed = ['pdf', 'doc', 'docx'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        if (move_uploaded_file($tempname, $folder)) {
            $relative = "uploads/resumes/" . $filename;
            $sql = "INSERT INTO resumes (user_id, filename, filepath) VALUES ('$user_id', '$filename', '$relative')";
            if (mysqli_query($conn, $sql)) {
                $message = "Resume uploaded successfully.";
            } else {
                $message = "Database error.";
            }
        } else {
            $message = "Failed to upload file.";
        }
    } else {
        $message = "Only PDF, DOC, or DOCX allowed.";
    }
}
?>

<h2>Upload Resume</h2>

<?php if ($message != ''): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Select Resume (PDF/DOC):</label>
    <input type="file" name="resume" required>
    <button type="submit">Upload</button>
</form>

<h3>Your Uploaded Resumes</h3>

<?php
$sql = "SELECT * FROM resumes WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='margin-bottom: 10px;'>";
        echo "<a href='../" . $row['filepath'] . "' target='_blank'>" . htmlspecialchars($row['filename']) . "</a>";
        echo " <small>(" . date("F j, Y", strtotime($row['created_at'])) . ")</small> ";
        echo "<a href='resume_upload.php?delete=" . $row['id'] . "' onclick='return confirm(\"Delete this resume?\")'>Delete</a>";
        echo "</div>";
    }
} else {
    echo "<p>No resumes uploaded yet.</p>";
}
?>

<?php include('footer.php'); ?>
