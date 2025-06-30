<?php
include('header.php');
include('../config/db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM jobs WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Apply Now logic
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply'])) {
        $user_id = $_SESSION['user_id'];
        $check = "SELECT * FROM applications WHERE seeker_id = $user_id AND job_id = $id";
        $check_result = mysqli_query($conn, $check);

        if (mysqli_num_rows($check_result) == 0) {
            $insert = "INSERT INTO applications (job_id, seeker_id) VALUES ($id, $user_id)";
            if (mysqli_query($conn, $insert)) {
                $message = "Application submitted!";
            } else {
                $message = "Something went wrong.";
            }
        } else {
            $message = "You have already applied to this job.";
        }
    }

    if ($row) {
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<div style='background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 5px #ccc;'>";
        echo "<p><b>Location:</b> " . $row['location'] . "</p>";
        echo "<p><b>Salary:</b> " . $row['salary'] . "</p>";
        echo "<p><b>Posted:</b> " . date('F j, Y', strtotime($row['created_at'])) . "</p>";
        echo "<hr>";
        echo "<p><b>Description:</b></p>";
        echo "<p>" . nl2br($row['description']) . "</p>";
        echo "</div>";

        // Show message if any
        if (isset($message)) {
            echo "<p style='margin-top:10px;'><b>$message</b></p>";
        }

        // Only show Apply button for seekers
        if ($_SESSION['user_type'] == 'seeker') {
            echo "<form method='POST' style='margin-top:15px;'>";
            echo "<button type='submit' name='apply'>Apply Now</button>";
            echo "</form>";
        }

        echo "<br><a href='job_listings.php'>&larr; Back to Listings</a>";
    } else {
        echo "<p>Job not found.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}

include('footer.php');
?>
