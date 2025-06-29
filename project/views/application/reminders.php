<div class="reminder-list">
    <h1>Follow-up Reminders</h1>
    <?php foreach ($applications as $app): ?>
        <div class="reminder-card">
            <p><strong><?php echo htmlspecialchars($app['title']); ?></strong> - <?php echo htmlspecialchars($app['company']); ?></p>
            <p>Status: <?php echo htmlspecialchars($app['status']); ?></p>
            <form action="/application/reminders/1" method="POST">
                <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                <input type="date" name="reminder_date" value="<?php echo $app['reminder_date']; ?>" aria-label="Set reminder date">
                <button type="submit">Set Reminder</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>