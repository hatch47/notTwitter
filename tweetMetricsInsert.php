<?php

// Check if the button is clicked
if (isset($_POST['like_button'])) {
    $tweet_id = $_POST['tweet_id']; // Get the tweet ID from the form

    // Insert a like into the tweetmetrics table
    $insert_query = "INSERT INTO TWEETMETRICS (TweetID, Likes) VALUES (?, 1) ON DUPLICATE KEY UPDATE Likes = Likes + 1";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "i", $tweet_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br><span id='success-message'>&#128151;</span>";
    } else {
        echo "Error adding like: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Check if the button is clicked
if (isset($_POST['retweet_button'])) {
    $tweet_id = $_POST['tweet_id']; // Get the tweet ID from the form

    // Insert a retweet into the tweetmetrics table
    $insert_query = "INSERT INTO TWEETMETRICS (TweetID, Retweets) VALUES (?, 1) ON DUPLICATE KEY UPDATE Retweets = Retweets + 1";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "i", $tweet_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br><span id='success-message'>&#128257;</span>";
    } else {
        echo "Error adding retweet: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// New comments and comment count
if (isset($_POST['comment_button'])) {
    $tweet_id = $_POST['tweet_id']; // Get the tweet ID from the form
    $comment_text = $_POST['comment_text']; // Get the comment text from the form

    // Insert the comment into the TWEETMETRICS table
    $insert_query = "INSERT INTO TWEETMETRICS (TweetID, newComments, Comments) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE Retweets = Retweets + 1";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "is", $tweet_id, $comment_text);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br><span id='success-message'>&#128172;</span>";
    } else {
        echo "Error adding comment: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}


// Comment content
if (isset($_POST['newComment_button'])) {
    $tweet_id = $_POST['tweet_id']; // Get the tweet ID from the form

    // Retrieve tweet information
    $tweet_query = "SELECT ua.USERNAME, t.CONTENT, ua.DISPLAYNAME, t.TWEETDATE, ua.PROFILEPIC, t.ID
        FROM USERACCOUNT ua
        LEFT JOIN TWEET t ON t.OWNERID = ua.ID
        WHERE t.ID = ?
        AND t.ID IS NOT NULL
        ORDER BY t.ID DESC";
    $tweet_stmt = mysqli_prepare($conn, $tweet_query);
    mysqli_stmt_bind_param($tweet_stmt, "i", $tweet_id);

    if (mysqli_stmt_execute($tweet_stmt)) {
        $tweet_result = mysqli_stmt_get_result($tweet_stmt);

        if (mysqli_num_rows($tweet_result) > 0) {
            while ($row = mysqli_fetch_assoc($tweet_result)) {
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
    } else {
        echo "Error retrieving tweet information: " . mysqli_error($conn);
    }

    mysqli_stmt_close($tweet_stmt);

      // Retrieve new comments and reactorID for the specified tweet_id
      $comment_query = "SELECT newComments, reactorID FROM TWEETMETRICS WHERE TweetID = ?";
      $comment_stmt = mysqli_prepare($conn, $comment_query);
      mysqli_stmt_bind_param($comment_stmt, "i", $tweet_id);
  
      if (mysqli_stmt_execute($comment_stmt)) {
          $comment_result = mysqli_stmt_get_result($comment_stmt);
  
          // Check if there are any new comments
          if (mysqli_num_rows($comment_result) > 0) {
              echo "<table>";
              echo "<tr><th></th><th>Comments</th></tr>";
  
              // Loop through the new comments and display them in a table
              while ($comment_row = mysqli_fetch_assoc($comment_result)) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($comment_row['reactorID']) . "</td>";
                  echo "<td>" . htmlspecialchars($comment_row['newComments']) . "</td>";
                  echo "</tr>";
              }
  
              echo "</table>";
          } else {
              echo "No new comments found for this tweet.";
          }
      } else {
          echo "Error retrieving comments: " . mysqli_error($conn);
      }
  
      mysqli_stmt_close($comment_stmt);
  }


?>

<script src="script.js"></script>
<script>
  // Automatically hide the success message after 2 seconds
  setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
      successMessage.style.display = 'none';
    }
  }, 2000); // 2000 milliseconds = 2 seconds
</script>