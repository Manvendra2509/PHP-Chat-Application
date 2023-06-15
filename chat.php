<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
  header("location: index.php");
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
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span>
            <?php echo $row['fname'] . " " . $row['lname'] ?>
          </span>
          <?php
          $current_timestamp = time(); // Get the current timestamp
          $logout_time = strtotime($row['lastseen']); // Convert the logout timestamp to a Unix timestamp
          $time_difference = $current_timestamp - $logout_time;
          $time_difference_hours = round($time_difference / (60 * 60)); // Convert the time difference to hours
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
  <script src="javascript/chat.js"></script>

</body>

</html>