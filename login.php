<?php
include "DBConnection.php";

if (isset($_POST['submit'])) { // check if submit button was pressed
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, user_password FROM USERACCOUNT WHERE username='@$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) { // if email exists
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['user_password']; // change to user_pass

        if (password_verify($password, $stored_password)) { // if password matches
            // Start the session
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];

            // Redirect the user to the home page
            header("Location: home.php");
            exit(); // make sure to exit to prevent further code execution
        } else {
            // password is incorrect
            echo "<br>Incorrect password. Please try again.";
        }
    } else {
        // email does not exist in database
        echo "<br>Username not found. Please try again.";
    }

    mysqli_close($conn); // close database connection
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <link rel="icon" href="Logo.png" type="image/png">
    <title>Login</title>
</head>
<body>
<div class="container">

    <br>
    <?php
    include "design.php";
    include "logout_navbar.php";
    ?>

    <br><br>
    <form action="login.php" method="post">
        <label class="container">Username:</label>
        <input type="text" name="username"><br><br>
        <label class="container">Password:</label>
        <input type="password" name="password"><br><br>
        <input type="submit" name="submit" value="Login"> 
    </form>

    <p>Not a member? <a href="signup.php">Sign up</a></p>

    <p>To view Not Twitter, you can log in with username: <b>Guest</b> password: <b>555555</b></p>
    

</div>
</body>
</html>
