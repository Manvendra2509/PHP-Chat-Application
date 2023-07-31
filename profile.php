<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
if (!isset($_SESSION['unique_id'])) {
  header("location: index.php");
  $_SESSION['last_activity'] = time();
}
?>

<?php include_once "header.php";
include_once "php/config.php";
$timestamp = date('Y-m-d H:i:s');
$sql1 = mysqli_query($conn, "INSERT INTO activity (user_id, session_id, timestamp, activity_description) VALUES ('{$_SESSION['unique_id']}', '{$_SESSION['session_id']}', '{$timestamp}', 'Opened profile settings page')");
?>

<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Edit Your Profile</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="First name">
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Last name">
          </div>
        </div>
        <div class="field input">
          <label>Old Password</label>
          <input type="password" name="oldpassword" placeholder="Enter old password">
          <i class="fas fa-eye"></i>
        </div>
        <div class="field input">
          <label>New Password</label>
          <input type="password" name="password" placeholder="Enter new password">
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Update Profile">
        </div>
        <div class="link"><a href="users.php">Go back</a></div>
      </form>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/profile.js"></script>
  <script>
        var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
    </script>
  <script src="javascript/timeout.js"></script>
</body>

</html>