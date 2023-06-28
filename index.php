<?php
session_start();
include_once "php/config.php";
if (isset($_SESSION['unique_id'])) {
  header("location: users.php");
}

?>

<?php include_once "header.php";

?>

<body>
  <div class="wrapper">
    <section class="form login">
      <div class="baskethunt-logo"> <img src="./php/images/logo.png" height="50px" /> </div>
      <header>
        <?php $sql = mysqli_query($conn, "SELECT * FROM homepage WHERE id=0");
        $row = mysqli_fetch_assoc($sql);

        if ($row['display'] == "Yes") {
          echo $row['title'];
        }
        ?>
      </header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script>
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>
  <script src="javascript/login.js"></script>

</body>

</html>