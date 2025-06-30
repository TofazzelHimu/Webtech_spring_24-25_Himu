<?php include 'header.php'; ?>

<p>
  Welcome <span style="color:#2a4d9b; font-weight:bold;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>!
  You're now in the <span style="color:#d35400; font-style:italic;"><?php echo $_SESSION['user_type']; ?></span> zone of the Job Portal.
  Feel free to dive in using the navigation bar above — everything you need is just a click away!
</p>



<?php include 'footer.php'; ?>
