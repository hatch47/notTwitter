<?php
require "session.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Explore</title>
</head>
<body>
<div class="container">

<br>
<?php
include "design.php";
include "loggedin_navbar.php";
?> 


<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

// Select the names from the table
$sql = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME, T.TWEETDATE, ua.PROFILEPIC
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        ORDER BY t.ID DESC";
$result = mysqli_query($conn, $sql);

    echo "<h2><b>Explore Tweets</b></h2>";
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