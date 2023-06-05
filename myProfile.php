<?php
require "session.php";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Profile</title>
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
<div class="designer-element" style="margin-left: 500px;">

<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

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
        echo "</div><br>";
    }
}

mysqli_close($conn); // close the database connection
?>
</div>
<div id="edit" style="display: none;">
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

  // Print the  names
  if (mysqli_num_rows($result) > 0) {
    echo "<h2><b>Followers</b></h2>";
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='text-offset'>";
          echo "<h3 style='flex: 0.3;' class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: rgb(145, 0, 0); margin-top: 0; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h3>";
        echo "</div><br>";
      }
  } else {
      echo "<br><p class='text-offset'>No followers found.</p>";
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
    echo "<h2><b>Following</b></h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='text-offset'>";
        // echo "<h3 class='username' style='margin-top: 0;'><b>" . $row['USERNAME'] . "</b></h3>";
        echo "<h3 style='flex: 0.3;' class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: rgb(145, 0, 0); margin-top: 0; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h3>";
        echo "</div>";
    }
} else {
    echo "<br><p class='text-offset'>Not following any accounts.</p>";
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
$sql = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        WHERE ua.ID = $user_id
        ORDER BY t.ID DESC";
$result = mysqli_query($conn, $sql);

// Print the names
if (mysqli_num_rows($result) > 0) {
    echo "<div class='content-container'>";
    echo "<h2 class='text-offset'><b>Tweets</b></h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='text-offset'>";
        echo "<div style='display: flex;'>";
        echo "<h3 style='flex: 0.3;' class='username'>" . $row['DISPLAYNAME'] . "</h3>";
        echo "<h5 style='flex: 0.0;' class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: black; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h5>";
        echo "</div>";
        echo "<h4 style='margin-top: 0;'>" . $row['CONTENT'] . "</h4>";
        echo "</div><br>";
    }
    echo "</div>";
} else {
    echo "<br>No tweets found.";
}

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




