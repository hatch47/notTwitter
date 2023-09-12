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

// Select the names from the table
$sql = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME, t.TWEETDATE, ua.PROFILEPIC, t.ID
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        WHERE (ua.ID = $user_id OR ua.ID IN (SELECT OWNERID FROM FOLLOWER WHERE FOLLOWERID = $user_id))
        AND t.ID IS NOT NULL
        ORDER BY t.ID DESC";
$result = mysqli_query($conn, $sql);

include "displayTweets.php";

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