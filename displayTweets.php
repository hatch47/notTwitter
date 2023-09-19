<?php
include "tweetMetricsInsert.php";
// Print the data in a table format
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='width: 800px; border: 1px solid lightgrey; padding: 10px;'>";
        echo "<table style='border-collapse: collapse; width: 100%;'>";
        echo "<tr>";
        echo "<td style='border: none; padding: 5px; background-color: white; display: flex; align-items: center;'>";
        echo "<img src='" . $row['PROFILEPIC'] . "' alt='Profile Picture' style='max-width: 60px; max-height: 60px;'>";
        echo "<div style='margin-left: 10px;'>";
        echo "<h3 class='username' style='margin: 0;'>" . $row['DISPLAYNAME'] . "</h3>";
        echo "<h5 class='username' style='margin-top: 5px;'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: black; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h5>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
        echo "<h4 style='margin: 0 0 5px 0;'>". $row['CONTENT'] . "</h4>";
        // echo "<h6 style='color: dimgrey; margin: 0 0 5px;'>&#128151; 0 &nbsp; &#128257; 0 &nbsp; &#128172; 0</h6>";
        include "tweetMetricsForm.php";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
        echo "<h6 style='color: dimgrey; margin: 0 0 5px;'>". $row['TWEETDATE'] . "</h6>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
        include "commentForm.php";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";
    }
} else {
    echo "No tweets found.";
}



?>



