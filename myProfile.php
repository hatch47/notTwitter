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

  // Print the names
if (mysqli_num_rows($result) > 0) {
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
} else {
    echo "<br><p class='text-offset'>No accounts.</p>";
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
    echo "<table style='border-collapse: collapse;'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td style='border: none;'>";
        echo "<h3 class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: rgb(145, 0, 0); margin-top: 0; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h3>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "<br><p class='text-offset'>No accounts.</p>";
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
$sql = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME, T.TWEETDATE
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        WHERE ua.ID = $user_id
        ORDER BY t.ID DESC";
$result = mysqli_query($conn, $sql);

// Print the data in a table format
if (mysqli_num_rows($result) > 0) {
    echo "<h2><b>Tweets</b></h2>";
    echo "<table style='border-collapse: collapse;'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td style='border: none; padding: 1px; background-color: white; width: 25%;'>";
        echo "<h5 class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: black; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h5>";
        echo "</td>";
        echo "<td style='border: none; padding: 1px; background-color: white;'>";
        echo "<h3 class='username'>" . $row['DISPLAYNAME'] . "</h3>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='border: none; padding: 1px; background-color: white;'>";
        echo "<h4 style='margin: -10px 0 5px 0;'>". $row['CONTENT'] . "</h4>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='border: none; padding: 1px; background-color: white;'>";
        echo "<h6 style='color: dimgrey; margin: 0 0 25px;'>". $row['TWEETDATE'] . "</h6>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No tweets found.";
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





