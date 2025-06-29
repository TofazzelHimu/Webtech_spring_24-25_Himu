<div class="application-table">
    <h1>Employer Actions Log</h1>
    <table>
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $app): ?>
                <tr>
                    <td><?php echo htmlspecialchars($app['title']); ?></td>
                    <td><?php echo htmlspecialchars($app['company']); ?></td>
                    <td><?php echo htmlspecialchars($app['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>