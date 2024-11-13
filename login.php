<?php session_start(); ?>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="assets/css/login.css">
<script>
    // Clear client-side storage
    sessionStorage.clear();
    localStorage.clear();

    function showAlert(message, redirectUrl = null) {
        alert(message);
        if (redirectUrl) {
            window.location.href = redirectUrl; // Redirect to the given URL
        }
    }
</script>
</head>

<body>
<?php
include("db.php");




if(isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($mysqli, $_POST['username']);
    $pass = mysqli_real_escape_string($mysqli, $_POST['password']);

    if($user == "" || $pass == "") {
        echo "Either username or password field is empty.";
        echo "<br/>";
        echo "<a href='login.php'>Go back</a>";
    } else {
        // Query the database to check if the username and password match any record
        $result = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$user' AND password=md5('$pass')")
                    or die("Error: " . mysqli_error($mysqli));

        $row = mysqli_fetch_assoc($result);

        if(is_array($row) && !empty($row)) {
            // Check if the account is approved
            if ($row['approval'] == 1) {
                // Account is approved, log the user in
                $validuser = $row['username'];
                $_SESSION['valid'] = $validuser;
                $_SESSION['name'] = $row['name'];
                $_SESSION['login_id'] = $row['user_id'];

                // Redirect to the index page
                header('Location: index.php');
            } else {
                // Account not approved, show a message and keep the user on the login page
                echo "<script>showAlert('Your account is pending admin approval.');</script>";
            }
        } else {
            // No matching username and password found, show the registration message
            echo "<script>showAlert('You are not registered. Please go to the registration page.', 'register.php');</script>";
        }
    }
} else {
}
?>

<div class="login-form">
<p><font size="+2">Login</font></p>

<form name="form1" method="post" action="">

<input placeholder="Username" type="text" name="username"><br/>
<input placeholder="Password" type="password" name="password"><br/>
<input type="submit" name="submit" value="Submit"><br/>

<button style="color:white; background-color:black"><a href="register.php" style="color:white">Register</a></button>

</form>
</div>

<?php

?>
</body>
</html>
