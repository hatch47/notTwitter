<?php

// Assuming you have a database connection established.

// Check if there are any likes for the tweet with TweetID equal to $row['ID']
$query_check_likes = "SELECT COUNT(*) AS like_count FROM TweetMetrics WHERE TweetID = " . $row['ID'] . " AND Likes = 1";
$result_check_likes = mysqli_query($conn, $query_check_likes);

if ($result_check_likes) {
    $like_data = mysqli_fetch_assoc($result_check_likes);
    $like_count = $like_data['like_count'];
} else {
    // Handle the database query error
    $like_count = 0;
}

// Check if there are any retweets for the tweet with TweetID equal to $row['ID']
$query_check_retweets = "SELECT COUNT(*) AS retweet_count FROM TweetMetrics WHERE TweetID = " . $row['ID'] . " AND Retweets = 1";
$result_check_retweets = mysqli_query($conn, $query_check_retweets);

if ($result_check_retweets) {
    $retweet_data = mysqli_fetch_assoc($result_check_retweets);
    $retweet_count = $retweet_data['retweet_count'];
} else {
    // Handle the database query error
    $retweet_count = 0;
}

// Check if there are any comments for the tweet with TweetID equal to $row['ID']
$query_check_comments = "SELECT COUNT(*) AS comment_count FROM TweetMetrics WHERE TweetID = " . $row['ID'] . " AND comments = 1";
$result_check_comments = mysqli_query($conn, $query_check_comments);

if ($result_check_comments) {
    $comment_data = mysqli_fetch_assoc($result_check_comments);
    $comment_count = $comment_data['comment_count'];
} else {
    // Handle the database query error
    $comment_count = 0;
}





echo '<div style="display: flex;">';
// like button
echo '<form method="post">';
echo '<input type="hidden" name="tweet_id" value="' . $row['ID'] . '">'; 
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $like_count . '</span>';
echo '<button type="submit" name="like_button" style="border: none; background: none; cursor: pointer;" title="Like Tweet">&#128151;&nbsp;</button>';
echo '</div>';
echo '</form>';

// retweet button
echo '<form method="post">';
echo '<input type="hidden" name="tweet_id" value="' . $row['ID'] . '">'; 
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $retweet_count . '</span>';
echo '<button type="submit" name="retweet_button" style="border: none; background: none; cursor: pointer;" title="Retweet Tweet">&#128257;&nbsp;</button>';
echo '</div>';
echo '</form>';

// comment button
echo '<form method="post">';
echo '<input type="hidden" name="tweet_id" value="' . $row['ID'] . '">'; 
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $comment_count . '</span>';
echo '<button type="submit" name="comment_button" style="border: none; background: none; cursor: pointer;" title="Comment on Tweet">&#128172;</button>';
echo '</div>';
echo '</form>';
echo '</div>';
?>

 <!-- &nbsp;  echo '<h5>0</h5>'; color: dimgrey; -->