<?php
session_start();
include("db.php");
include("topnav.php");
include("function.php");

// Check if role_id is provided in the URL
if (isset($_GET['role_id'])) {
    $role_id = intval($_GET['role_id']);
    $result = mysqli_query($mysqli, "SELECT * FROM roles WHERE role_id = $role_id");

    // If the role exists, fetch its details
    if ($role = mysqli_fetch_assoc($result)) {
        $title = $role['role_name'];
        $description = $role['role'];
        $can_create = $role['can_create'];
        $can_edit = $role['can_edit'];
        $can_delete = $role['can_delete'];
        $can_view = $role['can_view'];
    } else {
        echo "Role not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}

// Handle role update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_role'])) {
    $role_id = intval($_POST['role_id']);
    $title = $_POST['rolename'];
    $description = $_POST['role'];
    $can_create = isset($_POST['can_create']) ? 1 : 0;
    $can_edit = isset($_POST['can_edit']) ? 1 : 0;
    $can_delete = isset($_POST['can_delete']) ? 1 : 0;
    $can_view = isset($_POST['can_view']) ? 1 : 0;

    // Update the role in the database
    if (!empty($title) && !empty($description)) {
        $query = "UPDATE roles SET role_name='$title', role='$description', can_create=$can_create, can_edit=$can_edit, can_delete=$can_delete, can_view=$can_view WHERE role_id=$role_id";
        if (mysqli_query($mysqli, $query)) {
            echo "<script type='text/javascript'>
            alert('Role updated successfully!');
            window.location = 'roles.php';
            </script>";
            exit();
        } else {
            echo "Error updating role!";
        }
    } else {
        echo "Role name and description are required!";
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
    <link rel="stylesheet" href="assets/css/p.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Role</h2>
        <form action="edit_role.php?role_id=<?php echo $role_id; ?>" method="post">
            <input type="hidden" name="role_id" value="<?php echo $role_id; ?>">
            <div class="mb-3">
                <label for="rolename" class="form-label">Role Name</label>
                <input type="text" class="form-control" name="rolename" id="rolename" value="<?php echo $title; ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role Description</label>
                <input type="text" class="form-control" name="role" id="role" value="<?php echo $description; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Permissions</label><br>
                <input type="checkbox" name="can_create" <?php if ($can_create) echo 'checked'; ?>> Can Create<br>
                <input type="checkbox" name="can_edit" <?php if ($can_edit) echo 'checked'; ?>> Can Edit<br>
                <input type="checkbox" name="can_delete" <?php if ($can_delete) echo 'checked'; ?>> Can Delete<br>
                <input type="checkbox" name="can_view" <?php if ($can_view) echo 'checked'; ?>> Can View<br>
            </div>
            <button type="submit" name="update_role" class="btn btn-success">Update Role</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
