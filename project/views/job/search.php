<div class="search-results">
    <h1>Search Results</h1>
    <form class="search-form" action="/job/search" method="GET">
        <input type="text" name="q" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search jobs by title, company, or description" aria-label="Search jobs">
        <button type="submit">Search</button>
    </form>
    <div class="job-list">
        <?php if (empty($jobs)): ?>
            <p>No jobs found for your search. Try different keywords.</p>
        <?php else: ?>
            <?php foreach ($jobs as $job): ?>
                <div class="job-card">
                    <h2><?php echo htmlspecialchars($job['title']); ?></h2>
                    <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                    <p><?php echo substr(htmlspecialchars($job['description']), 0, 100); ?>...</p>
                    <a href="/job/view/<?php echo $job['id']; ?>" class="job-card button">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>