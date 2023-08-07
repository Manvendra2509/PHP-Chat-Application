<?php
// Start a new or resume an existing session
session_start();

// Include the 'config.php' file that contains the database connection details
include_once "php/config.php";

// Check if the user is not logged in or if the user is not an admin
if (!isset($_SESSION['unique_id']) or $_SESSION['role'] != "Admin") {

    // Redirect the user to the login page (index.php) if not logged in or not an admin
    header("location: index.php");

    // Store the current time as 'last_activity' in the session data
    $_SESSION['last_activity'] = time();
}
?>

<?php include_once "header.php"; ?>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <?php
                    // Fetch the user details from the 'users' table using the 'unique_id' from the session
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");

                    // Check if user details were found
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                    ?>
                    <!-- Display user information in the header section -->
                    <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                    <img src="php/images/<?php echo $row['img']; ?>" alt="">
                    <div class="details">
                        <span>
                            <?php echo $row['fname'] . " " . $row['lname'] ?>
                        </span>
                        <p>
                            <?php echo $row['status']; ?>
                        </p>
                    </div>
                </div>
                <div class="dropdown">
                    <!-- Dropdown menu for additional options -->
                    <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path
                                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu">
                        <!-- Dropdown menu options based on the user role (Admin has additional options) -->
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                        <?php if ($_SESSION['role'] == "Admin") { ?>
                            <li><a class="dropdown-item" href="#">User Log</a></li>
                            <li><a class="dropdown-item" href="register.php">Add Users</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="php/logout.php">Logout</a></li>
                    </ul>
                </div>
            </header>
            <div class="search">
                <!-- Search bar for filtering users by name -->
                <span class="text">Select a user to view activity log</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                <!-- Placeholder for displaying the user activity log -->
            </div>
        </section>
    </div>

    <!-- Include Bootstrap JS library for dropdown functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script src="javascript/log.js"></script>
    <script>
        // Pass the 'unique_id' from the session to the JavaScript variable 'uniqueId'
        var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
    </script>
    <script src="javascript/timeout.js"></script>
</body>
</html>
