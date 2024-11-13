<?php
session_start();
include("db.php");
include('topnav.php');

// Check if role_id is provided in the URL
if (isset($_GET['role_id'])) {
    $role_id = $_GET['role_id'];

    // Fetch current role data from the database
    $query = "SELECT * FROM roles WHERE role_id = '$role_id'";
    $result = mysqli_query($mysqli, $query);
    $role = mysqli_fetch_array($result);

    // Check if role data is not found
    if (!$role) {
        echo "Role not found.";
        exit;
    }
} else {
    // If no role_id is passed in the URL, redirect to roles.php
    echo "No role ID provided.";
    exit;
}

// Handle form submission and update role data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_role'])) {
    // Get updated role data from the form
    $role_id = mysqli_real_escape_string($mysqli, $_POST['role_id']); // Get role_id from POST
    $role_name = mysqli_real_escape_string($mysqli, $_POST['role_name']);
    $role_desc = mysqli_real_escape_string($mysqli, $_POST['role_desc']);

    // Update role data in the database
    $update_query = "UPDATE roles SET 
                     role_name = '$role_name', 
                     role = '$role_desc'
                     WHERE role_id = '$role_id'";

    if (mysqli_query($mysqli, $update_query)) {
        // Redirect to roles.php with success message
        echo "<script>alert('Role updated successfully!'); window.location.href = 'roles.php';</script>";
    } else {
        echo "<script>alert('Error updating role!'); window.location.href = 'roles.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
</head>

<body>
    <div class="container mt-5">
        <h3>Edit Role</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?role_id=' . $role_id; ?>" method="POST">
            <input type="hidden" name="role_id" value="<?php echo $role_id; ?>"> <!-- Hidden field to pass role_id -->
            <div class="mb-3">
                <label for="role_name" class="form-label">Role Name</label>
                <input type="text" class="form-control" name="role_name" value="<?php echo htmlspecialchars($role['role_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="role_desc" class="form-label">Role Description</label>
                <input type="text" class="form-control" name="role_desc" value="<?php echo htmlspecialchars($role['role']); ?>" required>
            </div>
            
            <button type="submit" name="save_role" class="btn btn-success">Save</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
