<?php
// Start the PHP session
session_start();

// Check if the user is an admin, if not, redirect to the users page
if ($_SESSION['role'] != "Admin") {
  header("location: users.php");
  // Update the last activity time in the session
  $_SESSION['last_activity'] = time();
}
?>

<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Homepage Settings</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <!-- Input field for Chat Application Title -->
        <div class="field input">
          <label>Chat Application Title</label>
          <input type="text" name="title" placeholder="Application Title">
        </div>
        <!-- Select field for Displaying the Application Title -->
        <div class="field input">
          <label>Display Application Title</label>
          <select class="form-select" id="inputGroupSelect01" name="display">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
        <!-- Input field for selecting the Application Logo -->
        <div class="field image">
          <label>Select Application Logo</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
        </div>
        <!-- Button to submit the form and apply the settings -->
        <div class="field button">
          <input type="submit" name="submit" value="Apply Settings">
        </div>
        <!-- Link to go back to the users page -->
        <div class="link"><a href="users.php">Go back</a></div>
      </form>
    </section>
  </div>

  <!-- Script to show/hide password -->
  <script src="javascript/pass-show-hide.js"></script>
  <!-- Script to handle homepage settings -->
  <script src="javascript/homepage_settings.js"></script>
  <!-- JavaScript code to set the uniqueId variable from the PHP session -->
  <script>
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>
  <!-- Script to handle session timeout -->
  <script src="javascript/timeout.js"></script>
</body>

</html>
