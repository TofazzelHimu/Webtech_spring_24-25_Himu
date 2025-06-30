<?php
include('header.php');
include('../config/db.php');

$application_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$reminder = '';
$message = '';

// Get existing reminder if any
$sql = "SELECT reminder FROM follow_ups WHERE application_id = $application_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $reminder = $row['reminder'];
}

// Save form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_reminder = mysqli_real_escape_string($conn, $_POST['reminder']);

    if ($reminder == '') {
        // Insert new
        $sql = "INSERT INTO follow_ups (application_id, reminder) VALUES ($application_id, '$new_reminder')";
    } else {
        // Update existing
        $sql = "UPDATE follow_ups SET reminder = '$new_reminder' WHERE application_id = $application_id";
    }

    if (mysqli_query($conn, $sql)) {
        $message = "Reminder saved successfully.";
        $reminder = $new_reminder;
    } else {
        $message = "Error saving reminder.";
    }
}
?>

<h2>Follow-up Reminder</h2>

<?php if ($message != '') { echo "<p>$message</p>"; } ?>

<form method="POST">
    <label>Reminder Note:</label>
    <textarea name="reminder" rows="5"><?php echo htmlspecialchars($reminder); ?></textarea>
    <button type="submit">Save Reminder</button>
</form>

<p><a href="application_status.php">&larr; Back to Applications</a></p>

<?php include('footer.php'); ?>
