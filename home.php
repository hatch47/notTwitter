<?php
require "session.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Home</title>
</head>
<body>
<div class="container">

<br>
<?php
include "design.php";
include "loggedin_navbar.php";
include "tweet.php";
?> 

<!-- <h3>Your Feed</h3> -->
<br>
<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

// Select the group names from the giftgroup table
// $sql = "SELECT groupname FROM giftgroup WHERE ownerid = $user_id";
$sql = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        WHERE ua.ID = $user_id OR (ua.ID IN (SELECT OWNERID FROM FOLLOWER WHERE FOLLOWERID = $user_id))
        ORDER BY t.ID DESC";
$result = mysqli_query($conn, $sql);

// Print the group names
if (mysqli_num_rows($result) > 0) {
    echo "<div class='content-container'>";
    while ($row = mysqli_fetch_assoc($result)) {
        // solid white can be switched to solid grey when figure out sizing
        echo "<div class='text-offset' style='border: .05px solid white; padding: 10px; background-color: white; width: 275%;'>";
        echo "<div style='display: flex;'>";
        echo "<h3 style='flex: 0.3;' class='username'>" . $row['DISPLAYNAME'] . "</h3>";
        echo "<h5 style='flex: 0.0;' class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: black; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h5>";
        echo "</div>";
        echo "<h4 style='margin-top: 0;'>" . $row['CONTENT'] . "</h4>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No tweets found.";
}


mysqli_close($conn); // close the database connection
?>

</div>
<script>
function redirectToProfile(username) {
    // Redirect to viewProfile.php with the username as a query parameter
    window.location.href = "viewProfile.php?username=" + encodeURIComponent(username);
}
</script>

</body>
</html>