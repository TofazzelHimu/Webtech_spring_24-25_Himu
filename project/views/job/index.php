<div class="job-board">
    <h1>Job Board</h1>
    <form class="search-form" action="/project/job/search" method="GET">
        <input type="text" name="q" placeholder="Search jobs by title, company, or description" aria-label="Search jobs">
        <button type="submit">Search</button>
    </form>
    <div class="job-list">
        <?php if (empty($jobs)): ?>
            <p>No jobs found. Please try again later or add some jobs to the database.</p>
        <?php else: ?>
            <?php foreach ($jobs as $job): ?>
                <div class="job-card">
                    <h2><?php echo htmlspecialchars($job['title']); ?></h2>
                    <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                    <p><?php echo substr(htmlspecialchars($job['description']), 0, 100); ?>...</p>
                    <div>
                        <a href="/project/job/view/<?php echo $job['id']; ?>" class="job-card button">View Details</a>
                        <button onclick="saveJob(1, <?php echo $job['id']; ?>)" class="job-card button">Save Job</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>