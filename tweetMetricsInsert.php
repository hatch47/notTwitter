<?php

// Check if the button is clicked
if (isset($_POST['like_button'])) {
    $tweet_id = $_POST['tweet_id']; // Get the tweet ID from the form

    // Insert a like into the tweetmetrics table
    $insert_query = "INSERT INTO TweetMetrics (TweetID, Likes) VALUES (?, 1) ON DUPLICATE KEY UPDATE Likes = Likes + 1";
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

    // Insert a like into the tweetmetrics table
    $insert_query = "INSERT INTO TweetMetrics (TweetID, Retweets) VALUES (?, 1) ON DUPLICATE KEY UPDATE Retweets = Retweets + 1";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "i", $tweet_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br><span id='success-message'>&#128257;</span>";
    } else {
        echo "Error adding retweet: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Check if the button is clicked
if (isset($_POST['comment_button'])) {
    $tweet_id = $_POST['tweet_id']; // Get the tweet ID from the form

    // Insert a like into the tweetmetrics table
    $insert_query = "INSERT INTO TweetMetrics (TweetID, Comments) VALUES (?, 1) ON DUPLICATE KEY UPDATE Comments = Comments + 1";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "i", $tweet_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br><span id='success-message'>&#128172;</span>";
    } else {
        echo "Error adding comment: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

?>

<script src="script.js"></script>
<script>
  // Automatically hide the success message after 5 seconds
  setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
      successMessage.style.display = 'none';
    }
  }, 2000); // 2000 milliseconds = 2 seconds
</script>