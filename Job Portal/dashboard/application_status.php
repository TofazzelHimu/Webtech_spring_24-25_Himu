<?php
include('header.php');
include('../config/db.php');

$user_id = $_SESSION['user_id'];

// Withdraw logic
if (isset($_GET['withdraw'])) {
    $app_id = intval($_GET['withdraw']);
    $del = $conn->prepare("DELETE FROM applications WHERE id = ? AND seeker_id = ?");
    $del->bind_param("ii", $app_id, $user_id);
    if ($del->execute()) {
        echo "<p style='color:green;'>Application withdrawn.</p>";
    } else {
        echo "<p style='color:red;'>Failed to withdraw application.</p>";
    }
    $del->close();
}

// Fetch applications
$sql = "SELECT a.id as app_id, j.title, a.status, a.applied_at
        FROM applications a
        JOIN jobs j ON a.job_id = j.id
        WHERE a.seeker_id = '$user_id'
        ORDER BY a.applied_at DESC";

$result = mysqli_query($conn, $sql);
?>

<h2>Your Applications</h2>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $app_id = $row['app_id'];
        echo "<div style='margin-bottom: 15px; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 5px #ccc;'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p><b>Status:</b> " . ucfirst($row['status']) . "</p>";
        echo "<p><b>Applied on:</b> " . date("F j, Y", strtotime($row['applied_at'])) . "</p>";

        // Check for interview
        $int = $conn->prepare("SELECT interview_time, location FROM interviews WHERE application_id = ?");
        $int->bind_param("i", $app_id);
        $int->execute();
        $int_result = $int->get_result();

        if ($int_result->num_rows > 0) {
            $int_row = $int_result->fetch_assoc();
            echo "<p style='color:green;'><b>Interview Scheduled:</b><br>";
            echo "📅 " . date("F j, Y g:i A", strtotime($int_row['interview_time'])) . "<br>";
            echo "📍 " . htmlspecialchars($int_row['location']) . "</p>";
        }

        $int->close();

        echo "<a href='follow_up.php?id=$app_id'>View / Set Follow-up</a><br>";
        echo "<a href='application_status.php?withdraw=$app_id' onclick='return confirm(\"Are you sure you want to withdraw this application?\")'>Withdraw</a>";
        echo "</div>";
    }
} else {
    echo "<p>You haven't applied to any jobs yet.</p>";
}
?>

<?php include('footer.php'); ?>
