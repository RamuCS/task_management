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
	$role = $_POST['role'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	// $roles = $_POST['roles'];
	$user = $_POST['username'];
	$pass = $_POST['password'];

	if (empty($role) || empty($user) || empty($pass) || empty($name) || empty($email)) {
		echo "<p style='color: red; text-align: center;'>All fields are required. Please fill in all fields.</p>";
	} else {
		// Check if $conn is not null before executing the query
		if ($mysqli) {
			$check_query = "SELECT * FROM users WHERE name = '$name' AND email = '$email' AND username = '$user'";
			$result = mysqli_query($mysqli, $check_query);

			if (mysqli_num_rows($result) > 0) {
				echo "<script>alert('Username or Email already exists!');</script>";
			} else {
				addusers($role, $name, $email, $user, $pass);
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
		<form method="post" action="">
			<select name="role">
				<option value="">Select Purpose</option>
				<option value="User">User</option>
				<option value="Admin">Admin</option>
			</select>

			<input type="text" name="name" placeholder="Full Name" required>
			<input type="email" name="email" placeholder="Email Address" required>

			<!-- <select name="roles">
				<option value="">Select Your Role</option>
				<option value="Admin">Admin</option>
				<option value="Manager">Manager</option>
				<option value="Staff">Staff</option>
				<option value="Workers">Workers</option>
				<option value="Maintenance">Maintenance</option>
			</select> -->

			<input type="text" name="username" placeholder="Username" required>
			<input type="password" name="password" placeholder="Password" required>
			<input type="submit" name="submit" value="Register">
		</form>
	</div>
</body>
</html>
