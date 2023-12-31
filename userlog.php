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
    <section class="users">
      <header>
        <div class="content">
          <?php
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_GET['user_id']}");
          $_SESSION['userlog-id'] = $_GET['user_id'];
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          }
          ?>
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
          <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg"
              width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
              <path
                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
            </svg>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="chatlog.php">Back</a></li>
          </ul>
        </div>
      </header>
      <div class="search">
        <span class="text">Select a session to view session log</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">

      </div>
    </section>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
  <script src="javascript/userlog.js"></script>
  <script>
        var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
    </script>
  <script src="javascript/timeout.js"></script>
</body>

</html>