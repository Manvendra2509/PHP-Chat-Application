<?php
// Start the PHP session
session_start();

// Set the default timezone to Asia/Kolkata
date_default_timezone_set('Asia/Kolkata');

// If the 'unique_id' session variable is not set, redirect the user to the "index.php" page
if (!isset($_SESSION['unique_id'])) {
  header("location: index.php");
  $_SESSION['last_activity'] = time();
}
?>

<?php
// Include the "header.php" and "config.php" files
include_once "header.php";
include_once "php/config.php";

// Get the current timestamp and insert a new activity record in the database to log that the user opened the profile settings page
$timestamp = date('Y-m-d H:i:s');
$sql1 = mysqli_query($conn, "INSERT INTO activity (user_id, session_id, timestamp, activity_description) VALUES ('{$_SESSION['unique_id']}', '{$_SESSION['session_id']}', '{$timestamp}', 'Opened profile settings page')");
?>

<body>
  <div class="wrapper">
    <section class="form signup">
      <!-- Display a header for the profile settings form -->
      <header>Edit Your Profile</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- Display an error text element to show validation or server-side errors -->
        <div class="error-text"></div>
        <!-- Input fields for first name and last name -->
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
        <!-- Input field for old password -->
        <div class="field input">
          <label>Old Password</label>
          <input type="password" name="oldpassword" placeholder="Enter old password">
          <i class="fas fa-eye"></i> <!-- Icon to show/hide password -->
        </div>
        <!-- Input field for new password -->
        <div class="field input">
          <label>New Password</label>
          <input type="password" name="password" placeholder="Enter new password">
          <i class="fas fa-eye"></i> <!-- Icon to show/hide password -->
        </div>
        <!-- Button to submit the form and update profile settings -->
        <div class="field button">
          <input type="submit" name="submit" value="Update Profile">
        </div>
        <!-- Link to go back to the "users.php" page -->
        <div class="link"><a href="users.php">Go back</a></div>
      </form>
    </section>
  </div>

  <!-- JavaScript files -->
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/profile.js"></script>
  <script>
    // Pass the 'unique_id' session variable to JavaScript
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>
  <script src="javascript/timeout.js"></script>
</body>

</html>
