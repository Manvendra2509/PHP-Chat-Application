<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
  header("location: index.php");
}
?>

<?php include_once "header.php"; ?>

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

</body>

</html>