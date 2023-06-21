<?php
// Get the user ID from the current session  
$user_id = $_SESSION['user_id'];
$user_profile = $_GET['username'];


// Retrieve and display profile picture based on username
$sql = "SELECT PROFILEPIC FROM USERACCOUNT WHERE USERNAME = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_profile);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $profilePicPath = $row['PROFILEPIC'];

  // Display the profile picture if it exists
  if (!empty($profilePicPath) && file_exists($profilePicPath)) {
    echo "<img src='$profilePicPath' style='width: 200px; height: 250px;' alt='Profile Picture'>";
  } else {
    echo "<img src='ProfileLogo.png' style='width: 200px; height: 250px;' alt='Logo'>";
  }

}
?>