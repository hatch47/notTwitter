<?php
require "session.php";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>My Profile</title>
</head>
<body>
<div class="container">

<br>

<?php
include "design.php";
include "loggedin_navbar.php";
?> 
<br>
<div class="button-container">
  <button class="click-button" onclick="toggleFollowers()">Followers</button>
  <button class="click-button" onclick="toggleFollowing()">Following</button>
  <button class="click-button" onclick="toggleEdit()">Edit Profile</button>
</div>
</div>
<!-- <div class="designer-element" style="margin-left: 500px;"> -->
<div class="container">

<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

echo "<br><div style='width: 800px; border: 1px solid lightgrey; padding: 10px;'>";
include "profilepic.php";

$sql = "SELECT USERNAME, DISPLAYNAME
        FROM USERACCOUNT
        WHERE ID = $user_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<h1 class='username'><b>" . $row['DISPLAYNAME'] . "</b></h1>";
        echo "<h5 class='username'><b>" . $row['USERNAME'] . "</b></h5>";
        echo "</div>";
    }
}

$sql = "SELECT BIO
        FROM USERACCOUNT
        WHERE ID = $user_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<p>Bio: ";
        echo "<b class='username'>" . $row['BIO'] . "</b></p>";
        echo "</div>";
    }
}
echo "</div><br>";

mysqli_close($conn); // close the database connection
?>
</div>
<div class ="edit-profile-container" id="edit" style="display: none;">
<!-- <div class ="edit-profile-container" id="edit"> -->
<?php
include "editProfile.php";
?> 
<br>
</div>



<div class="container">


<div id="followers" style="display: none;">
  <?php
  include "DBConnection.php"; // include the database connection file

  // Get the user ID from the current session
  $user_id = $_SESSION['user_id'];

  // Select the names from the user table
  $sql = "SELECT ua.USERNAME
  FROM USERACCOUNT ua
  JOIN FOLLOWER f ON f.FOLLOWERID = ua.ID
  WHERE f.OWNERID = $user_id";
  $result = mysqli_query($conn, $sql);

  // Print the names
if (mysqli_num_rows($result) > 0) {
    echo "<div class='followers-container'>";
    echo "<h2><b>Followers</b></h2>";
    echo "<table style='border-collapse: collapse;'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td style='border: none;'>";
        echo "<h3 class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: rgb(145, 0, 0); margin-top: 0; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h3>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    echo "</div>";
} else {
  echo "<div class='no-follow'>";
  echo "<br><h4 class='text-offset'>No Followers to Display.</h4>";
  echo "</div>";
}

  ?>
</div>

<div id="following" style="display: none;">
<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

$sql = "SELECT ua.USERNAME
FROM USERACCOUNT ua
JOIN FOLLOWER f ON f.OWNERID = ua.ID
WHERE f.FOLLOWERID = $user_id";
$result = mysqli_query($conn, $sql);

// Print the names
if (mysqli_num_rows($result) > 0) {
  echo "<div class='following-container'>";
    echo "<h2><b>Following</b></h2>";
    echo "<table style='border-collapse: collapse;'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td style='border: none;'>";
        echo "<h3 class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: rgb(145, 0, 0); margin-top: 0; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h3>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    echo "</div>";
} else {
  echo "<div class='no-follow'>";
  echo "<br><h4 class='text-offset'>No Following to Display.</h4>";
  echo "</div>";
}

mysqli_close($conn); // close the database connection
?>
</div>


<!-- <div class="container"> -->
<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

// Select the names from the user table
$sql = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME, t.TWEETDATE, ua.PROFILEPIC, t.ID
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        WHERE ua.ID = $user_id AND t.ID IS NOT NULL
        ORDER BY t.ID DESC";
$result = mysqli_query($conn, $sql);
include "displayTweets.php";

mysqli_close($conn); // close the database connection
?>

<!-- </div> -->
</div>

<script>
  function toggleFollowers() {
    var followersDiv = document.getElementById('followers');
    if (followersDiv.style.display === 'none') {
      followersDiv.style.display = 'block';
    } else {
      followersDiv.style.display = 'none';
    }
  }
</script>

<script>
  function toggleFollowing() {
    var followersDiv = document.getElementById('following');
    if (followersDiv.style.display === 'none') {
      followersDiv.style.display = 'block';
    } else {
      followersDiv.style.display = 'none';
    }
  }
</script>

<script>
  function toggleEdit() {
    var followersDiv = document.getElementById('edit');
    if (followersDiv.style.display === 'none') {
      followersDiv.style.display = 'block';
    } else {
      followersDiv.style.display = 'none';
    }
  }
</script>

<script>
function redirectToProfile(username) {
    // Redirect to viewProfile.php with the username as a query parameter
    window.location.href = "viewProfile.php?username=" + encodeURIComponent(username);
}
</script>
</body>
</html>





