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


// Handle the profile picture upload
if (!empty($_FILES['profile_picture']['name'])) {
  $file_name = $_FILES['profile_picture']['name'];
  $file_tmp = $_FILES['profile_picture']['tmp_name'];
  $file_destination = 'profile_pictures/' . $file_name;

  // Move the uploaded file to the destination directory
  if (move_uploaded_file($file_tmp, $file_destination)) {
    // Update the PROFILEPIC column in the USERACCOUNT table
    $sql = "UPDATE USERACCOUNT SET PROFILEPIC = '$file_destination' WHERE ID = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Profile picture saved.";
    } else {
      echo "Error updating profile picture.";
    }
  } else {
    echo "Error uploading profile picture.";
  }
}




  if (!empty($_POST['new_username'])) {
    $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    $sql = "UPDATE USERACCOUNT SET USERNAME = '@$new_username' WHERE ID = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Saved";
    } else {
      echo "Error updating username.";
    }
  }

  if (!empty($_POST['new_displayname'])) {
    $new_displayname = mysqli_real_escape_string($conn, $_POST['new_displayname']);
    $sql = "UPDATE USERACCOUNT SET DISPLAYNAME = '$new_displayname' WHERE ID = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Saved";
    } else {
      echo "Error updating username.";
    }
  }

  if (!empty($_POST['new_email'])) {
    $new_email = mysqli_real_escape_string($conn, $_POST['new_email']);
    $sql = "UPDATE USERACCOUNT SET EMAIL = '$new_email' WHERE ID = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Saved";
    } else {
      echo "Error updating email.";
    }
  }

  if (!empty($_POST['new_bio'])) {
    $new_bio = mysqli_real_escape_string($conn, $_POST['new_bio']);
    $sql = "UPDATE USERACCOUNT SET BIO = '$new_bio' WHERE ID = $user_id";
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
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <b><label>Edit Email</label><br>
    <input type="email" name="new_email"><br>

    <br><label>Edit Username</label><br>
    <input type="text" name="new_username"><br>

    <br><label>Edit Display Name</label><br>
    <input type="text" name="new_displayname"><br>

    <br><label>Edit Bio</label><br>
    <input type="text" name="new_bio"><br>

    <br><label>Upload Profile Picture</label><br></b>
    <input type="file" name="profile_picture"><br><br>

    <input type="submit" name="save_changes" value="Save" onclick="showSavedMessage()">
  </form>
</div>

<script>
function showSavedMessage() {
  alert("Changes Saved");
  location.href = location.href;
}
</script>



</body>
</html>