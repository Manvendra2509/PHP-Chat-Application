<?php
// Start the session to manage user sessions.
session_start();

// Include the configuration file to access database and other settings.
include_once "php/config.php";

// If the user is already logged in (i.e., the 'unique_id' session variable is set), redirect to the 'users.php' page.
if (isset($_SESSION['unique_id'])) {
  header("location: users.php");
}

?>

<?php
// Include the 'header.php' file to display the common header of the application.
include_once "header.php";
?>

<body>
  <div class="wrapper">
    <!-- The login form section -->
    <section class="form login">
      <div class="baskethunt-logo"> <img src="./php/images/logo.png" height="50px" /> </div>
      <header>
        <?php
        // Fetch the homepage data from the database where id is 0.
        $sql = mysqli_query($conn, "SELECT * FROM homepage WHERE id=0");
        $row = mysqli_fetch_assoc($sql);

        // Check if the homepage display is set to "Yes" and then display the title.
        if ($row['display'] == "Yes") {
          echo $row['title'];
        }
        ?>
      </header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <!-- Input field for the password -->
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i> <!-- This icon is used to toggle the password visibility -->
        </div>
        <!-- Submit button to proceed with login -->
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
    </section>
  </div>

  <!-- Include JavaScript files -->
  <script src="javascript/pass-show-hide.js"></script> <!-- This script is used to show/hide the password -->
  <script>
    // Assign the 'unique_id' session variable value to a JavaScript variable for future use (not used in this code snippet).
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>
  <script src="javascript/login.js"></script>
  <!-- The main login script for handling form submission and other login-related tasks -->

</body>

</html>