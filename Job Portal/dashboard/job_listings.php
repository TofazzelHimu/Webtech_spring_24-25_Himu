<?php
include('header.php');
include('../config/db.php');

$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$sql = "SELECT * FROM jobs";
if (!empty($search)) {
    $sql .= " WHERE title LIKE '%$search%' OR location LIKE '%$search%'";
}
$sql .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<h2>Job Listings</h2>

<form method="GET" action="">
    <input type="text" name="search" placeholder="Search by title or location" value="<?php echo $search; ?>">
    <button type="submit">Search</button>
</form>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='background: #fff; padding: 15px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 0 5px #ccc;'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p><b>Location:</b> " . $row['location'] . "</p>";
        echo "<p><b>Salary:</b> " . $row['salary'] . "</p>";
        echo "<p><b>Posted:</b> " . date('F j, Y', strtotime($row['created_at'])) . "</p>";
        echo "<a href='job_details.php?id=" . $row['id'] . "'>View Details</a>";
        echo "</div>";
    }
} else {
    echo "<p>No jobs found.</p>";
}
?>

<?php include('footer.php'); ?>
