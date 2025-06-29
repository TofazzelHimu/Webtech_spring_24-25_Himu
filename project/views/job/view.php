<div class="job-detail">
    <h1><?php echo htmlspecialchars($job['title']); ?></h1>
    <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
    <p><strong>Posted:</strong> <?php echo htmlspecialchars($job['posted_at']); ?></p>
    <p><strong>Description:</strong></p>
    <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
    <form action="/application/apply/1/<?php echo $job['id']; ?>" method="POST">
        <button type="submit" class="job-card button">Apply Now</button>
    </form>
</div>