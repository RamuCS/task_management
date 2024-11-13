<?php
session_start();
include('db.php');
include('topnav.php');

if (!isset($_SESSION['valid'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit; // Ensure the rest of the page is not loaded
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADMIN DASHBOARD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
</head>
<body>


    <h1>user reports</h1>
    <script type="text/javascript">
    // Prevent the back button from functioning after logout
    window.history.forward();
    function noBack() { window.history.forward(); }
    window.onload = noBack;
    window.onpageshow = function(evt) { if (evt.persisted) noBack(); }
</script>

</body>
</html>