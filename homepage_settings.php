<?php
session_start();
if ($_SESSION['role'] != "Admin") {
  header("location: users.php");
  $_SESSION['last_activity'] = time();
}
?>

<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Homepage Settings</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Chat Application Title</label>
          <input type="text" name="title" placeholder="Application Title">
        </div>
        <div class="field input">
          <label>Display Application Title</label>
          <select class="form-select" id="inputGroupSelect01" name="display">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
        <div class="field image">
          <label>Select Application Logo</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Apply Settings">
        </div>
        <div class="link"><a href="users.php">Go back</a></div>
      </form>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/homepage_settings.js"></script>
  <script>
    var uniqueId = "<?php echo $_SESSION['unique_id']; ?>";
  </script>
  <script src="javascript/timeout.js"></script>
</body>

</html>