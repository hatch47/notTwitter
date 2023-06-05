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
</div>
</div>
<div class="designer-element" style="margin-left: 500px;">

<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session  // @contentposter
$user_id = $_SESSION['user_id'];
$user_profile = $_GET['username'];

if (isset($_GET['username'])) {
  $user_profile = $_GET['username'];
  
  $sql = "SELECT USERNAME, DISPLAYNAME
          FROM USERACCOUNT
          WHERE USERNAME = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $user_profile);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<div>";
          echo "<h1 class='username'><b>" . $row['DISPLAYNAME'] . "</b></h1>";
          echo "<h5 class='username'><b>" . $row['USERNAME'] . "</b></h5>";
          echo "</div>";
      }
  }
}


$sql = "SELECT BIO
        FROM USERACCOUNT
        WHERE USERNAME = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_profile);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<p>Bio: ";
        echo "<b class='username'>" . $row['BIO'] . "</b></p>";
        echo "</div><br>";
    }
}



// Add the button for following
echo "<form method='POST'>";
echo "<input type='hidden' name='username' value='$user_profile'>";
echo "<button type='submit' style='color: white; background-color: rgb(145, 0, 0); margin-left: -1490px;' name='follow_button'>Follow</button>";
echo "</form>";

if (isset($_POST['follow_button'])) {
    // Get the username
    $username = $_POST['username'];

    // Get the owner_id from the USERACCOUNT table based on the username
    $select_owner_id_sql = "SELECT ID FROM USERACCOUNT WHERE USERNAME = ?";
    $select_owner_id_stmt = mysqli_prepare($conn, $select_owner_id_sql);
    mysqli_stmt_bind_param($select_owner_id_stmt, "s", $username);
    mysqli_stmt_execute($select_owner_id_stmt);
    $owner_id_result = mysqli_stmt_get_result($select_owner_id_stmt);

    if (mysqli_num_rows($owner_id_result) > 0) {
        $owner_id_row = mysqli_fetch_assoc($owner_id_result);
        $owner_id = $owner_id_row['ID'];

        // Get the follower_id from the current session
        $follower_id = $_SESSION['user_id'];

        // Perform the INSERT query
        $insert_sql = "INSERT INTO FOLLOWER (OWNERID, FOLLOWERID) VALUES (?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "ss", $owner_id, $follower_id);
        mysqli_stmt_execute($insert_stmt);

        // Display success or error message
        if (mysqli_stmt_affected_rows($insert_stmt) > 0) {
            echo "<p id='success-message'>You're following this account</p>";
        } else {
            echo "Error occurred while following.";
        }
    } else {
        echo "User not found.";
    }
}

// Add the button for unfollowing
echo "<form method='POST'>";
echo "<input type='hidden' name='username' value='$user_profile'>";
echo "<button type='submit' style='color: white; background-color: rgb(145, 0, 0); margin-top:3px; margin-left: -1478px;' name='unfollow_button'>Unfollow</button>";
echo "</form>";

if (isset($_POST['unfollow_button'])) {
    // Get the username
    $username = $_POST['username'];

    // Get the owner_id from the USERACCOUNT table based on the username
    $select_owner_id_sql = "SELECT ID FROM USERACCOUNT WHERE USERNAME = ?";
    $select_owner_id_stmt = mysqli_prepare($conn, $select_owner_id_sql);
    mysqli_stmt_bind_param($select_owner_id_stmt, "s", $username);
    mysqli_stmt_execute($select_owner_id_stmt);
    $owner_id_result = mysqli_stmt_get_result($select_owner_id_stmt);

    if (mysqli_num_rows($owner_id_result) > 0) {
        $owner_id_row = mysqli_fetch_assoc($owner_id_result);
        $owner_id = $owner_id_row['ID'];

        // Get the follower_id from the current session
        $follower_id = $_SESSION['user_id'];

        // Perform the DELETE query
        $delete_sql = "DELETE FROM FOLLOWER WHERE OWNERID = ? AND FOLLOWERID = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($delete_stmt, "ss", $owner_id, $follower_id);
        mysqli_stmt_execute($delete_stmt);

        // Display success or error message
        if (mysqli_stmt_affected_rows($delete_stmt) > 0) {
            echo "<p id='success-message'>You're no longer following this account</p>";
        } else {
            echo "<p id='success-message'>You're not following this account</p>";
        }
    } else {
        echo "User not found.";
    }
}

mysqli_close($conn); // close the database connection
?>
</div>

<div class="container">


<div id="followers" style="display: none;">
  <?php
  include "DBConnection.php"; // include the database connection file

  // Get the user ID from the current session
  $user_id = $_SESSION['user_id'];
  $user_profile = $_GET['username'];

  // Select the names from the user table
  $sql = "SELECT ua_follower.USERNAME AS Follower
  FROM USERACCOUNT ua_owner
  JOIN FOLLOWER f ON ua_owner.ID = f.OWNERID
  JOIN USERACCOUNT ua_follower ON ua_follower.ID = f.FOLLOWERID
  WHERE ua_owner.USERNAME = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $user_profile);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Print the  names
  if (mysqli_num_rows($result) > 0) {
    echo "<h2 class='text-offset'><b>Followers</b></h2>";
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='text-offset'>";
          echo "<h3 style='flex: 0.3;' class='username'><b><a href='viewProfile.php?username=" . urlencode($row['Follower']) . "' style='color: rgb(145, 0, 0); margin-top: 0; text-decoration: none;'>" . $row['Follower'] . "</a></b></h3>";
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
$user_profile = $_GET['username'];

$sql = "SELECT ua_following.USERNAME AS Following
FROM USERACCOUNT ua_owner
JOIN FOLLOWER f ON ua_owner.ID = f.FOLLOWERID
JOIN USERACCOUNT ua_following ON ua_following.ID = f.OWNERID
WHERE ua_owner.USERNAME = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_profile);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Print the names
if (mysqli_num_rows($result) > 0) {
    echo "<h2 class='text-offset'><b>Following</b></h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='text-offset'>";
        echo "<h3 style='flex: 0.3;' class='username'><b><a href='viewProfile.php?username=" . urlencode($row['Following']) . "' style='color: rgb(145, 0, 0); margin-top: 0; text-decoration: none;'>" . $row['Following'] . "</a></b></h3>";
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
$user_profile = $_GET['username'];

// Select the names from the user table
$sql = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        WHERE ua.USERNAME = ?
        ORDER BY t.ID DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_profile);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Print the names
if (mysqli_num_rows($result) > 0) {
    echo "<div class='content-container'>";
    echo "<h2 class='text-offset'><b>Tweets</b></h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='text-offset'>";
        echo "<div style='display: flex;'>";
        echo "<h3 style='flex: 0.5;' class='username'>" . $row['DISPLAYNAME'] . "</h3>";
        echo "<h5 style='flex: 0.5;' class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: black; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h5>";
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
  // Automatically hide the success message after 3 seconds
  setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
      successMessage.style.display = 'none';
    }
  }, 3000); // 3000 milliseconds = 3 seconds
</script>

</body>
</html>





