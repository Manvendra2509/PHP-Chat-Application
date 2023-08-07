<?php
// Start or resume the session
session_start();

// Include the configuration file
include_once "php/config.php";

// Set the default timezone to Asia/Kolkata
date_default_timezone_set('Asia/Kolkata');

// Check if the user is not logged in (no unique_id in session)
if (!isset($_SESSION['unique_id'])) {
  // Redirect to the index.php (login) page
  header("location: index.php");

  // Set the last_activity session variable to the current time
  $_SESSION['last_activity'] = time();
} 
// Check if user_id is not provided in the URL query string
else if (!isset($_GET['user_id'])) {
  // If the logged-in user is an admin, redirect to the users.php page
  // Else, redirect to the chat.php page with a default user_id (134451108)
  if ($_SESSION['role'] == "Admin") {
    header("location: users.php");
  } else {
    header("location: chat.php?user_id=134451108");
  }
}
?>

<?php
// Include the header.php file
include_once "header.php";

// Set the incoming_id session variable to the user_id provided in the URL query string
$_SESSION['incoming_id'] = $_GET['user_id']
?>

<body>
  <!-- The chat interface -->
  <div class="chat-wrapper">
    <section class="chat-area">
      <header>
        <?php
        // Get the current timestamp
        $timestamp = date('Y-m-d H:i:s');

        // Escape special characters in the user_id from the URL query string
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

        // Query the database to fetch user information based on the user_id
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");

        // Insert a new activity record indicating that the chat page is opened for the specified user_id
        $sql2 = mysqli_query($conn, "INSERT INTO activity (user_id, session_id, timestamp, activity_description) VALUES ('{$_SESSION['unique_id']}', '{$_SESSION['session_id']}','{$timestamp}', 'Opened chat page for user ID: {$user_id}')");

        // Check if there is any user information with the specified user_id
        if (mysqli_num_rows($sql) > 0) {
          // Fetch the user information
          $row = mysqli_fetch_assoc($sql);
        } else {
          // If no user information found, redirect to the users.php page
          header("location: users.php");
        }

        // Check the user's status and set the offline class accordingly
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        ?>

        <!-- Back button to users.php (only visible to admins) -->
        <a href="users.php" class="back-icon"<?php if ($_SESSION['role'] == "User") { echo ' style="display: none"'; } ?>>
          <i class="fas fa-arrow-left"></i>
        </a>

        <!-- User's profile image and status dot -->
        <div class="chat-img-container">
          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <div class="status-dot <?php echo $offline; ?>">
            <i class="fas fa-circle"></i>
          </div>
        </div>

        <!-- User's details: Name and last seen/active status -->
        <div class="details">
          <span>
            <?php echo $row['fname'] . " " . $row['lname'] ?>
          </span>
          <?php
          // Calculate the time difference between the current time and the user's last seen time
          $current_timestamp = time();
          $logout_time = strtotime($row['lastseen']);
          $time_difference = $current_timestamp - $logout_time;
          $time_difference_hours = round($time_difference / (60 * 60));
          if ($row['status'] == "Offline now") {
            // Determine the last seen message based on the time difference
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

        <!-- Dropdown menu with user options -->
        <div class="dropdown">
          <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
              <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
            </svg>
          </button>
          <ul class="dropdown-menu">
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

      <!-- Preview container for sharing files (image, video, audio) -->
      <div id="preview-container">
        <div id="preview">
          <div id="preview-title-bar">
            <div id="preview-title">Share with <?php echo $row['fname'] . " " . $row['lname'] ?></div>
            <div id="title-bar-controls">
              <button id="close-preview-button" onclick="cancelPreview()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                </svg>
              </button>
            </div>
          </div>
          <div id="preview-content">
            <div id="previewImageContainer">
              <!-- Image preview -->
              <img id="previewImage" alt="Preview" style="display: none;" />
              <!-- Video preview -->
              <video id="previewVideo" controls style="display: none;">
                <source src="" />
              </video>
              <!-- Audio preview -->
              <audio id="previewAudio" controls style="display: none;">
                <source src="" />
              </audio>
            </div>
            <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
            <input id="preview-input" type="text" placeholder="Enter caption" />
            <button id="preview-button" type="button" onclick="submitFile()">Submit</button>
          </div>
        </div>
      </div>

      <!-- The chat box to display messages -->
      <div class="chat-box">
        <!-- Messages will be displayed here -->
      </div>

      <!-- The typing area for sending messages -->
      <form action="#" class="typing-area">
        <div class="chat-utilities">
          <div class="utility-container">
            <ul class="utility-group">
              <!-- Emoji selector -->
              <li class="emoji-selector" id="emojiSelector">
                <div class="input-container">
                  <input id="emojiSearch" type="text" name="" id="" placeholder="Search...">
                </div>
                <ul id="emojiList" class="emoji-list">
                  <!-- Emoji list will be populated here -->
                </ul>
              </li>
              <!-- Emoji selector icon -->
              <li id="emojiSelectorIcon">
                <svg id="emojiSelectorIconSVG" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                  <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
                </svg>
              </li>
              <!-- Attachment icon -->
              <li id="attachmentsIcon" onclick="document.getElementById('attachButton').click()">
                <input type="file" name="attachment" id="attachButton" style="display: none;" accept="image/*,audio/*,video/*" />
                <!-- Button trigger for attaching the image -->
                <button type="button" id="attachmentButton" onclick="document.getElementById('attachButton').click()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                    <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z" />
                  </svg>
                </button>
              </li>
            </ul>
          </div>
        </div>
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" id="message-box" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button class="send-button">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
          </svg>
        </button>
      </form>
    </section>
  </div>
  <!-- Load Bootstrap and custom JavaScript files -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="javascript/chat.js"></script>
  <script>
    // Store the unique_id of the current user in a JavaScript variable
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>
  <script src="javascript/timeout.js"></script>
</body>
</html>
