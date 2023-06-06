<?php
require "session.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Search</title>
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

$sql = "SELECT USERNAME
        FROM USERACCOUNT";

$result = mysqli_query($conn, $sql); // Execute the query and assign the result to $result


// Print the names
if (mysqli_num_rows($result) > 0) {
    echo "<h2><b>Accounts to Follow</b></h2>";
    echo "<table style='border-collapse: collapse;'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td style='border: none;'>";
        echo "<h3 class='username'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: rgb(145, 0, 0); margin-top: 0; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h3>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<br><p class='text-offset'>No accounts.</p>";
}

mysqli_close($conn); // close the database connection
?>
