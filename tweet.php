<?php
// require "session.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<title>tweet</title>
</head>
<body>
<div class="container">

<br><br>
<?php
// include "design.php";
// include "loggedin_navbar.php";
include "DBConnection.php";

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Getting user id
  $user_id = $_SESSION['user_id'];

  // Prepare and bind parameters
  $content = mysqli_real_escape_string($conn, $_POST['content']);

  // Insert data into Tweet table
  $sql = "INSERT INTO Tweet (OwnerID, Content) VALUES ('$user_id','$content')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo "<br><span id='success-message'>Tweet Sent</span>";
  }

  $conn->close();
}
?>

<script src="script.js"></script>
<script>
  // Automatically hide the success message after 5 seconds
  setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
      successMessage.style.display = 'none';
    }
  }, 5000); // 5000 milliseconds = 5 seconds
</script>

<form method='post'>
  <label><b>New Tweet</b></label><br>
  <!-- <input type="text" name="content" style="width: 500px; height: 25px;" required> -->
  <textarea type="text" name="content" rows="3" cols="50" required></textarea>
  <br>
  <input type="submit" value="Post Tweet">
</form>



</div>
</body>
</html>
