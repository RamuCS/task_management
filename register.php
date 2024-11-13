<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration Form</title>
	<link rel="stylesheet" href="assets/css/t.css">
</head>
<body>
<?php
include("db.php");
include("function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$user = $_POST['username'];
	$pass = $_POST['password'];

	// Check if all fields are filled
	if (empty($user) || empty($pass) || empty($name) || empty($email)) {
		echo "<p style='color: red; text-align: center;'>All fields are required. Please fill in all fields.</p>";
	} else {
		// Check if $conn (DB connection) is valid
		if ($mysqli) {
			$check_query = "SELECT * FROM users WHERE name = '$name' AND email = '$email' AND username = '$user'";
			$result = mysqli_query($mysqli, $check_query);

			if (mysqli_num_rows($result) > 0) {
				echo "<script>alert('Username or Email already exists!');</script>";
			} else {
				// Call the function to add the user to the database
				addusers($name, $email, $user, $pass);
				echo "<script>alert('Registration successful! Redirecting to login...');</script>";
				echo "<script>window.location.href = 'login.php';</script>";
				exit();
			}
		} else {
			echo "<p style='color: red; text-align: center;'>Database connection error.</p>";
		}
	}
}
?>

	<div class="registration-form">
		<h2>Register</h2>
		<form method="POST" action="">
			<input type="text" name="name" placeholder="Full Name" required>
			<input type="email" name="email" placeholder="Email Address" required>
			<input type="text" name="username" placeholder="Username" required>
			<input type="password" name="password" placeholder="Password" required>
			<input type="submit" name="submit" value="Register">
		</form>
		<button><a href="login.php">Login</a></button>
	</div>
</body>
</html>
