<?php session_start(); ?>
<?php
include("db.php");
$id = $_GET['id'];
$result=mysqli_query($mysqli, "DELETE FROM predefined_tasks WHERE id=$id  ");
$result=mysqli_query($mysqli,"DELETE FROM tasks where id = $id");
header("Location:addpretask.php");
?>

