<?php
    // Start the session and set the default timezone
    session_start();
    date_default_timezone_set('Asia/Kolkata');
    include_once "php/config.php";

    // Check if the user is logged in and has admin role, if not, redirect to index.php
    if (!isset($_SESSION['unique_id']) or $_SESSION['role'] != "Admin") {
        header("location: index.php");
        $_SESSION['last_activity'] = time();
    } else {
        // Check if the 'user_id' parameter is set in the URL
        if (!isset($_GET['user_id'])){
            // If 'user_id' is not set, redirect to log.php
            header("location: log.php");
        }
    }
?>

<?php include_once "header.php"; ?>

<body>
    <div class="wrapper activity-wrapper">
        <section class="activity">
            <header>
                <div class="content">
                    <?php
                    // Fetch user details based on the 'user_id' passed in the URL
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_GET['user_id']}");
                    $_SESSION['userlog-id'] = $_GET['user_id'];
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                    ?>
                    <!-- Display user's profile image, name, and status -->
                    <a href="log.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
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
                <!-- Dropdown menu for user options -->
                <div class="dropdown">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path
                                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu">
                        <!-- Display different options based on the user's role -->
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                        <?php if ($_SESSION['role'] == "Admin") { ?>
                            <li><a class="dropdown-item" href="log.php">User Log</a></li>
                            <li><a class="dropdown-item" href="register.php">Add Users</a></li>
                            <li><a class="dropdown-item" href="homepage_settings.php">Homepage Settings</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="php/logout.php">Logout</a></li>
                    </ul>
                </div>
            </header>
            <div class="activity-list">

            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <!-- Include JavaScript file for activity log -->
    <script src="javascript/activitylog.js"></script>
    <script>
        // Pass the unique_id of the logged-in user to JavaScript for further processing
        var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
    </script>
    <script src="javascript/timeout.js"></script>
</body>

</html>
