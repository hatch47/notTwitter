<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Sign Up</title>
</head>
<body>
<div class="container">
<br>

<?php
include "design.php";
include "logout_navbar.php";
include "DBConnection.php";

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if password and confirm password match
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $con_password = mysqli_real_escape_string($conn, $_POST['con_password']);
  if ($password !== $con_password) {
    echo "Error: Passwords do not match";
    exit();
  }

  // Set the desired profile picture file name
$desired_file_name = 'ProfileLogo91847.png'; // Change this to the desired file name

  // Prepare and bind parameters
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = password_hash($password, PASSWORD_DEFAULT);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  // $sql = "INSERT INTO USERACCOUNT (email, username, user_password, displayname) VALUES ('$email', '@$username', '$password', '$username')";
  $sql = "INSERT INTO USERACCOUNT (email, username, user_password, displayname, PROFILEPIC) VALUES ('$email', '@$username', '$password', '$username', 'profile_pictures/$desired_file_name')";

  // Execute statement and check for errors
  if ($conn->query($sql) === TRUE) {
    echo "<br>Account Created";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>
<br><br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return matchPassword();">
  <label class="container">Email:</label>
  <input type="email" name="email" required><br><br>
  <label class="container">Username:</label>
  <span>@ </span>
  <input type="text" name="username" id="usernameInput" required><br>
  <span id="usernameError" style="color: red;"></span>
  <!-- <input type="username" name="username" required><br><br> -->
  <br>
  <label class="container">Password:</label>
  <input type="password" id="password" name="password" minlength="6" required><br><br>
  <label class="container">Confirm Password:</label>
  <input type="password" id="con_password" name="con_password" minlength="6" required><br><br>
  <input type="submit" value="Sign Up">
</form>


</div>
</body>
</html>