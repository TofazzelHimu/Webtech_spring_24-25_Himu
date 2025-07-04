<?php include 'header.php'; ?>
<?php require_once '../config/db.php'; ?>

<?php
$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
$edit_data = null;
$employer_id = $_SESSION['user_id'];
$message = '';

if ($edit_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM interviews WHERE id = ? AND employer_id = ?");
    $stmt->bind_param("ii", $edit_id, $employer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
    $stmt->close();
}
?>

<h2>Interview Scheduling</h2>

<?php if ($_SESSION['user_type'] === 'employer'): ?>
    <h3><?php echo $edit_data ? "Edit Interview" : "Schedule New Interview"; ?></h3>

    <?php if ($message) echo "<p><b>$message</b></p>"; ?>

    <form method="POST">
        <?php if ($edit_data): ?>
            <input type="hidden" name="interview_id" value="<?php echo $edit_data['id']; ?>">
        <?php endif; ?>

        <label>Select Application:</label><br>
        <?php if ($edit_data): ?>
            <input type="text" name="application_id" value="<?php echo $edit_data['application_id']; ?>" readonly><br><br>
        <?php else: ?>
            <select name="application_id" required>
                <option value="">-- Select Application --</option>
                <?php
                $query = "
                    SELECT a.id, u.name AS seeker_name, u.email, j.title
                    FROM applications a
                    JOIN jobs j ON a.job_id = j.id
                    JOIN users u ON a.seeker_id = u.id
                    WHERE j.employer_id = ?
                    AND a.id NOT IN (
                        SELECT application_id FROM interviews
                    )
                ";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">[App ID: ' . $row['id'] . '] '
                    . htmlspecialchars($row['seeker_name']) . ' ('
                    . htmlspecialchars($row['email']) . ') – '
                    . htmlspecialchars($row['title']) . '</option>';
                }

                $stmt->close();
                ?>
            </select><br><br>
        <?php endif; ?>

        <label>Date & Time:</label>
        <input type="datetime-local" name="interview_time" required value="<?php echo $edit_data ? date('Y-m-d\TH:i', strtotime($edit_data['interview_time'])) : ''; ?>"><br><br>

        <label>Location:</label>
        <input type="text" name="location" required value="<?php echo $edit_data['location'] ?? ''; ?>"><br><br>

        <button type="submit"><?php echo $edit_data ? "Update Interview" : "Schedule Interview"; ?></button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $interview_id = isset($_POST['interview_id']) ? intval($_POST['interview_id']) : 0;
        $application_id = intval($_POST['application_id']);
        $interview_time = $_POST['interview_time'];
        $location = htmlspecialchars(trim($_POST['location']));

        if (!preg_match("/^[a-zA-Z0-9\s,.-]{2,100}$/", $location)) {
            echo "<p style='color:red;'>Invalid location format</p>";
        } else {
            if ($interview_id > 0) {
                $stmt = $conn->prepare("UPDATE interviews SET interview_time = ?, location = ? WHERE id = ? AND employer_id = ?");
                $stmt->bind_param("ssii", $interview_time, $location, $interview_id, $_SESSION['user_id']);
                $stmt->execute();
                $stmt->close();
                echo "<p style='color:green;'>Interview updated successfully.</p>";
            } else {
                $stmt = $conn->prepare("INSERT INTO interviews (application_id, employer_id, interview_time, location) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiss", $application_id, $_SESSION['user_id'], $interview_time, $location);
                if ($stmt->execute()) {
                    echo "<p style='color:green;'>Interview scheduled successfully.</p>";
                } else {
                    echo "<p style='color:red;'>Failed to schedule interview.</p>";
                }
                $stmt->close();
            }
        }
    }
    ?>
<?php endif; ?>

<hr>

<h3>My Upcoming Interviews</h3>
<?php
if ($_SESSION['user_type'] === 'seeker') {
    $query = "
        SELECT i.interview_time, i.location, j.title
        FROM interviews i
        JOIN applications a ON i.application_id = a.id
        JOIN jobs j ON a.job_id = j.id
        WHERE a.seeker_id = ?
        ORDER BY i.interview_time ASC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>".htmlspecialchars($row['title'])."</strong><br>";
        echo "At: " . htmlspecialchars($row['location']) . "<br>";
        echo "On: " . date("F j, Y g:i A", strtotime($row['interview_time'])) . "</p><hr>";
    }

    $stmt->close();
} elseif ($_SESSION['user_type'] === 'employer') {
    if (isset($_GET['cancel'])) {
        $cancel_id = (int) $_GET['cancel'];
        $cancel_stmt = $conn->prepare("DELETE FROM interviews WHERE application_id = ? AND employer_id = ?");
        $cancel_stmt->bind_param("ii", $cancel_id, $_SESSION['user_id']);
        if ($cancel_stmt->execute()) {
            echo "<p style='color:green;'>Interview cancelled.</p>";
        } else {
            echo "<p style='color:red;'>Failed to cancel interview.</p>";
        }
        $cancel_stmt->close();
    }

    $stmt = $conn->prepare("
    SELECT i.id, i.application_id, i.interview_time, i.location
    FROM interviews i
    WHERE i.employer_id = ?
    ORDER BY i.interview_time DESC
    ");

    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>Application ID:</strong> " . $row['application_id'] . "<br>";
        echo "📍 " . htmlspecialchars($row['location']) . "<br>";
        echo "🗓 " . date("F j, Y g:i A", strtotime($row['interview_time'])) . "<br><br>";
        echo '<a href="?edit=' . $row['id'] . '">Edit</a> | ';
        echo '<a href="?cancel=' . $row['application_id'] . '" onclick="return confirm(\'Are you sure you want to cancel this interview?\')">Cancel Interview</a></p><hr>';
    }

    $stmt->close();
}
?>

<?php include 'footer.php'; ?>
