<?php
// Start a PHP session to manage user sessions.
session_start();

// Check if the user is not an admin. If not, redirect to the users.php page (user access restriction).
if ($_SESSION['role'] != "Admin") {
  header("location: users.php");
  $_SESSION['last_activity'] = time(); // Store the current timestamp in the session variable 'last_activity'.
}
?>

<?php include_once "header.php"; ?>
<!-- Include the header section of the HTML -->

<body>
  <!-- Wrapper for the registration form -->
  <div class="wrapper">
    <!-- Registration form section with the class 'signup' -->
    <section class="form signup">
      <!-- Header for the registration form -->
      <header>BasketHunt Chat App</header>
      <!-- Form to add a new user -->
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- Container to display error messages -->
        <div class="error-text"></div>
        <!-- Container for first name and last name input fields -->
        <div class="name-details">
          <!-- Input field for first name -->
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="First name" required>
          </div>
          <!-- Input field for last name -->
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Last name" required>
          </div>
        </div>
        <!-- Input field for email address -->
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <!-- Input field for password -->
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter new password" required>
          <i class="fas fa-eye"></i> <!-- Icon to show/hide password -->
        </div>
        <!-- Dropdown select field for role (Admin or User) -->
        <div class="field input">
          <select class="form-select" id="inputGroupSelect01" name="role">
            <option selected>Role...</option>
            <option value="Admin">Admin</option>
            <option value="User">User</option>
          </select>
        </div>
        <!-- Input field for selecting an image -->
        <div class="field image">
          <label>Select Image</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>
        <!-- Button to submit the registration form -->
        <div class="field button">
          <input type="submit" name="submit" value="Add User">
        </div>
        <!-- Link to go back to the users.php page -->
        <div class="link"><a href="users.php">Go back</a></div>
      </form>
    </section>
  </div>

  <!-- JavaScript code to show/hide password -->
  <script src="javascript/pass-show-hide.js"></script>
  <!-- JavaScript code for handling user registration -->
  <script src="javascript/signup.js"></script>
  <!-- JavaScript variable to store the unique user ID -->
  <script>
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>
  <!-- JavaScript code to manage user timeout -->
  <script src="javascript/timeout.js"></script>
</body>

</html>
