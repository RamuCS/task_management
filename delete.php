<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include("db.php");

//getting id of the data from url
$user_id = $_GET['user_id'];

//deleting the row from table

$result=mysqli_query($mysqli, "DELETE FROM users WHERE user_id=$user_id");

//redirecting to the display page (view.php in our case)
header("Location:users.php");
?>

