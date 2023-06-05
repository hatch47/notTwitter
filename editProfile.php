<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <title>Login</title>
</head>
<body>

<?php
include "DBConnection.php"; // include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_POST['user_id'];

  if (!empty($_POST['new_username'])) {
    $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    $sql = "UPDATE useraccount SET USERNAME = '@$new_username' WHERE ID = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Saved";
    } else {
      echo "Error updating username.";
    }
  }

  if (!empty($_POST['new_displayname'])) {
    $new_displayname = mysqli_real_escape_string($conn, $_POST['new_displayname']);
    $sql = "UPDATE useraccount SET DISPLAYNAME = '$new_displayname' WHERE ID = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Saved";
    } else {
      echo "Error updating username.";
    }
  }

  if (!empty($_POST['new_email'])) {
    $new_email = mysqli_real_escape_string($conn, $_POST['new_email']);
    $sql = "UPDATE useraccount SET EMAIL = '$new_email' WHERE ID = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Saved";
    } else {
      echo "Error updating email.";
    }
  }

  if (!empty($_POST['new_bio'])) {
    $new_bio = mysqli_real_escape_string($conn, $_POST['new_bio']);
    $sql = "UPDATE useraccount SET BIO = '$new_bio' WHERE ID = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Saved";
    } else {
      echo "Error updating bio.";
    }
  }
}
?>

<div class="container">
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <label>Edit Email</label><br>
    <input type="email" name="new_email"><br>

    <br><label>Edit Username</label><br>
    <input type="text" name="new_username"><br>

    <br><label>Edit Display Name</label><br>
    <input type="text" name="new_displayname"><br>

    <br><label>Edit Bio</label><br>
    <input type="text" name="new_bio"><br><br>

    <input type="submit" name="save_changes" value="Save" onclick="showSavedMessage()">
  </form>
</div>


<script>
function showSavedMessage() {
  alert("Saved");
  location.href = location.href;
}
</script>



</body>
</html>