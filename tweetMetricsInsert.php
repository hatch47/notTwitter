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

    // Retrieve new comments for the specified tweet_id
    $select_query = "SELECT newComments FROM TWEETMETRICS WHERE TweetID = ?";
    $stmt = mysqli_prepare($conn, $select_query);
    mysqli_stmt_bind_param($stmt, "i", $tweet_id);

    if (mysqli_stmt_execute($stmt)) {
        // Execute the query
        $result = mysqli_stmt_get_result($stmt);

        // Check if there are any new comments
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Comments</th></tr>";

            // Loop through the new comments and display them in a table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . htmlspecialchars($row['newComments']) . "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "No new comments found for this tweet.";
        }
    } else {
        echo "Error retrieving comments: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
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