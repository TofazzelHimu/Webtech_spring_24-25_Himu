<?php include 'header.php'; ?>
<?php
if ($_SESSION['user_type'] !== 'employer') {
    echo "<p style='color:red;'>Only Employers can access this page.</p>";
    include 'footer.php';
    exit();
}

require_once '../config/db.php';

$employer_id = $_SESSION['user_id'];
$message = '';

// DELETE
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ? AND employer_id = ?");
    $stmt->bind_param("ii", $delete_id, $employer_id);
    $stmt->execute();
    $stmt->close();
    $message = "Job deleted successfully.";
}

// EDIT
$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
$edit_data = null;

if ($edit_id) {
    $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND employer_id = ?");
    $stmt->bind_param("ii", $edit_id, $employer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
    $stmt->close();
}

// POST or UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $loc = trim($_POST['location']);
    $sal = trim($_POST['salary']);
    $job_id = isset($_POST['job_id']) ? intval($_POST['job_id']) : 0;

    if (!preg_match("/^[a-zA-Z0-9\s,.-]{2,150}$/", $title)) {
        $message = "Invalid title format.";
    } elseif (!preg_match("/^[a-zA-Z0-9\s,.-]{2,100}$/", $loc)) {
        $message = "Invalid location format.";
    } else {
        if ($job_id > 0) {
            // UPDATE
            $stmt = $conn->prepare("UPDATE jobs SET title = ?, description = ?, location = ?, salary = ? WHERE id = ? AND employer_id = ?");
            $stmt->bind_param("ssssii", $title, $desc, $loc, $sal, $job_id, $employer_id);
            $stmt->execute();
            $stmt->close();
            header("Location: employer.php");
            exit();
        } else {
            // INSERT
            $stmt = $conn->prepare("INSERT INTO jobs (employer_id, title, description, location, salary) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $employer_id, $title, $desc, $loc, $sal);
            if ($stmt->execute()) {
                $message = "Job posted successfully.";
            } else {
                $message = "Error posting job.";
            }
            $stmt->close();
        }
    }
}
?>

<h2><?php echo $edit_data ? "Edit Job" : "Post a New Job"; ?></h2>
<?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

<form method="POST">
    <?php if ($edit_data): ?>
        <input type="hidden" name="job_id" value="<?php echo $edit_data['id']; ?>">
    <?php endif; ?>

    <label>Title:</label><br>
    <input type="text" name="title" required placeholder="e.g. React Developer" value="<?php echo $edit_data['title'] ?? ''; ?>"><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" required placeholder="Responsibilities..."><?php echo $edit_data['description'] ?? ''; ?></textarea><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" required placeholder="e.g. Dhaka or Remote" value="<?php echo $edit_data['location'] ?? ''; ?>"><br><br>

    <label>Salary:</label><br>
    <input type="text" name="salary" required placeholder="e.g. 25,000 BDT" value="<?php echo $edit_data['salary'] ?? ''; ?>"><br><br>

    <button type="submit"><?php echo $edit_data ? "Update Job" : "Post Job"; ?></button>
</form>

<hr>

<h3>Your Posted Jobs</h3>
<?php
$stmt = $conn->prepare("SELECT id, title, created_at FROM jobs WHERE employer_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$jobs = $stmt->get_result();

while ($job = $jobs->fetch_assoc()) {
    echo "<p><strong>" . htmlspecialchars($job['title']) . "</strong><br>";
    echo "Posted on: " . date("F j, Y", strtotime($job['created_at'])) . "<br>";

    $job_id = $job['id'];
    $app_stmt = $conn->prepare("SELECT COUNT(*) FROM applications WHERE job_id = ?");
    $app_stmt->bind_param("i", $job_id);
    $app_stmt->execute();
    $app_stmt->bind_result($app_count);
    $app_stmt->fetch();
    $app_stmt->close();

    echo "Applicants: $app_count<br>";
    echo '<a href="job_applicants.php?job_id=' . $job_id . '">View Details</a> | ';
    echo '<a href="employer.php?edit=' . $job_id . '">Edit</a> | ';
    echo '<a href="employer.php?delete=' . $job_id . '" onclick="return confirm(\'Delete this job?\')">Delete</a>';
    echo "</p><hr>";
}

$stmt->close();
?>

<?php include 'footer.php'; ?>
