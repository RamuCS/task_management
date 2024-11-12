<?php
session_start();
include('db.php');
include('topnav.php');
include('function.php');

if (isset($_GET['role_id'])) { // Removed the misplaced semicolon here
    $role_id = $_GET['role_id'];
    $result = mysqli_query($mysqli, "DELETE FROM roles WHERE role_id = $role_id");
    header("location: roles.php");
}
?>
