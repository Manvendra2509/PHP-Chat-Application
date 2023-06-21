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
        $sql = mysqli_query($conn, "SELECT * FROM messages WHERE session_id = {$_GET['session_id']}");
        $sql2 = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['userlog-id']}");
        $_SESSION['sessionlog-id'] = $_GET['session_id'];

          $row = mysqli_fetch_assoc($sql);
          $row2 = mysqli_fetch_assoc($sql2);
        ?>
        <a href="userlog.php?user_id=<?php echo $_SESSION['userlog-id']; ?>" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row2['img']; ?>" alt="">
        <div class="details">
          <span>
            <?php echo $row2['fname'] . " " . $row2['lname'] ?>
          </span>
        </div>
      </header>
      <div class="chat-box">

      </div>
    </section>
  </div>
  <script src="javascript/sessionlog.js"></script>
  <script>
        var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
    </script>
  <script src="javascript/timeout.js"></script>
</body>

</html>