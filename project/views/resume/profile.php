<div class="profile-meter">
    <h1>Profile Completeness</h1>
    <p><strong>Profile Strength:</strong> <?php echo $resume['profile_strength'] ?? 0; ?>%</p>
    <progress value="<?php echo $resume['profile_strength'] ?? 0; ?>" max="100" aria-label="Profile strength"></progress>
</div>