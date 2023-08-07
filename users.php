<?php
// Start a PHP session to manage user sessions.
session_start();

// Include the 'config.php' file to access database connection and other settings.
include_once "php/config.php";

// If the 'unique_id' session variable is not set (user is not logged in), redirect to the 'index.php' page.
if (!isset($_SESSION['unique_id'])) {
  header("location: index.php");
  $_SESSION['last_activity'] = time(); // Update the 'last_activity' session variable to the current time.
} else if ($_SESSION['role'] == "User") {
  // If the user is logged in and has a role of "User", redirect to the admin 'chat.php' page.
  header("location: chat.php?user_id=134451108");
}
?>
<?php include_once "header.php"; ?>
<!-- Include the 'header.php' file to display the common header of the application. -->

<body>
  <div class="wrapper">
    <!-- The 'wrapper' div is used for page layout purposes. -->

    <section class="users">
      <!-- The 'users' section contains the main content of the page. -->

      <header>
        <!-- The header section containing user information and dropdown menu -->

        <div class="content">
          <!-- The 'content' div displays user details with their profile image, full name, and status. -->

          <?php
          // Query the 'users' table in the database to fetch the user's details based on 'unique_id'.
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          }
          ?>

          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <!-- Display the user's profile image using the 'img' column from the database. -->

          <div class="details">
            <!-- The 'details' div contains the user's full name and status. -->

            <span>
              <?php echo $row['fname'] . " " . $row['lname'] ?>
              <!-- Display the user's first name and last name. -->
            </span>
            <p>
              <?php echo $row['status']; ?>
              <!-- Display the user's status. -->
            </p>
          </div>
        </div>

        <div class="dropdown">
          <!-- The 'dropdown' div contains the dropdown menu with user actions. -->

          <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- The button triggers the dropdown menu on click. -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
              class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
              <path
                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
            </svg>
          </button>

          <ul class="dropdown-menu">
            <!-- The unordered list contains the items of the dropdown menu. -->

            <li><a class="dropdown-item" href="#">Settings</a></li>
            <!-- 'Settings' link for user settings. -->

            <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
            <!-- 'My Profile' link to view and edit user profile. -->

            <?php if ($_SESSION['role'] == "Admin") { ?>
            <!-- Show additional options if the user's role is "Admin". -->

            <li><a class="dropdown-item" href="log.php">User Log</a></li>
            <!-- 'User Log' link to view logs for user activities. -->

            <li><a class="dropdown-item" href="register.php">Add Users</a></li>
            <!-- 'Add Users' link for the admin to add new users. -->

            <li><a class="dropdown-item" href="homepage_settings.php">Homepage Settings</a></li>
            <!-- 'Homepage Settings' link for admin to manage homepage settings. -->

            <?php } ?>

            <li><a class="dropdown-item" href="php/logout.php">Logout</a></li>
            <!-- 'Logout' link to log out the user. -->
          </ul>
        </div>
      </header>

      <div class="search">
        <!-- The 'search' div contains the search input and button for user search. -->

        <span class="text">Select a user to start chat</span>
        <!-- Text to prompt the user to select a user to start a chat. -->

        <input type="text" placeholder="Enter name to search...">
        <!-- Input field for searching users by name. -->

        <button><i class="fas fa-search"></i></button>
        <!-- Search button with an icon from the Font Awesome library. -->
      </div>

      <div class="users-list">
        <!-- The 'users-list' div will be populated dynamically with a list of available users for chat. -->
      </div>
    </section>
    <!-- End of the 'users' section -->

  </div>
  <!-- End of the 'wrapper' div -->

  <!-- Include Bootstrap JavaScript for dropdown functionality -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

  <!-- Include custom JavaScript file for user functionality -->
  <script src="javascript/users.js"></script>

  <script>
    // Store the 'unique_id' session variable in a JavaScript variable for future use.
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>

  <!-- Include custom JavaScript file for session timeout handling -->
  <script src="javascript/timeout.js"></script>
</body>

</html>
<!-- End of the HTML document -->
