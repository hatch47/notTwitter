<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];


// Retrieve the profile picture from the database
$sql = "SELECT PROFILEPIC FROM USERACCOUNT WHERE ID = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $profilePicPath = $row['PROFILEPIC'];

  // Display the profile picture if it exists
  if (!empty($profilePicPath) && file_exists($profilePicPath)) {
    echo "<img src='$profilePicPath' style='max-width: 450px; max-height: 250px;' alt='Profile Picture'>";
  } else {
    echo "<img src='ProfileLogo.png' style='max-width: 250px; max-height: 250px;' alt='Logo'>";
  }
}
// } else {
//     echo "<img src='ProfileLogo.png' style='width: 200px; height: 250px;' alt='Logo'>";
// }

?>
