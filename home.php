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
$sql = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME, T.TWEETDATE, ua.PROFILEPIC
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        WHERE ua.ID = $user_id OR (ua.ID IN (SELECT OWNERID FROM FOLLOWER WHERE FOLLOWERID = $user_id))
        ORDER BY t.ID DESC";
$result = mysqli_query($conn, $sql);

// Print the data in a table format
if (mysqli_num_rows($result) > 0) {
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

</div>
<script>
function redirectToProfile(username) {
    // Redirect to viewProfile.php with the username as a query parameter
    window.location.href = "viewProfile.php?username=" + encodeURIComponent(username);
}
</script>

</body>
</html>