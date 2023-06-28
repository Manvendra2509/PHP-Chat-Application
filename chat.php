<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
  header("location: index.php");
  $_SESSION['last_activity'] = time();
}

?>



<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
        if (mysqli_num_rows($sql) > 0) {
          $row = mysqli_fetch_assoc($sql);
        } else {
          header("location: users.php");
        }
        ?>
        <a href="users.php" class="back-icon" <?php if ($_SESSION['role'] == "User") { echo ' style="display: none"';} ?>><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span>
            <?php echo $row['fname'] . " " . $row['lname'] ?>
          </span>
          <?php
          $current_timestamp = time();
          $logout_time = strtotime($row['lastseen']);
          $time_difference = $current_timestamp - $logout_time;
          $time_difference_hours = round($time_difference / (60 * 60));
          if ($row['status'] == "Offline now") {
            if ($time_difference_hours < 1) {
              $last_seen_message = "Last seen less than an hour ago";
            } elseif ($time_difference_hours == 1) {
              $last_seen_message = "Last seen 1 hour ago";
            } else {
              $last_seen_message = "Last seen " . $time_difference_hours . " hours ago";
            }
          } else {
            $last_seen_message = "Active now";
          }

          ?>
          <p>
            <?php echo $last_seen_message; ?>
          </p>
        </div>
        <div class="dropdown">
          <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg"
              width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
              <path
                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
            </svg>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
            <?php if($_SESSION['role'] == "Admin") { ?>
            <li><a class="dropdown-item" href="chatlog.php">User Log</a></li> 
            <li><a class="dropdown-item" href="register.php">Add Users</a></li> 
            <li><a class="dropdown-item" href="homepage_settings.php">Homepage Settings</a></li> 
            <?php } ?>
            <li><a class="dropdown-item" href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>">Logout</a></li>
          </ul>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>

    </section>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
  <script src="javascript/chat.js"></script>
  <script>
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>
  <script src="javascript/timeout.js"></script>

</body>

</html>