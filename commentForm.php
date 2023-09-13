<?php

// Comment form
echo '<div id="commentForm" style="display: none;"><form method="POST">';
echo '<input type="hidden" name="tweet_id" value="' . $row['ID'] . '">';
echo '<textarea name="comment_text" rows="2" cols="50" placeholder="Add a comment"></textarea><br>';
echo '<input type="submit" style="background-color: rgb(145, 0, 0); color: white;" name="comment_button" value="Comment">';
echo '</form></div>';
?>