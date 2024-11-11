<?php
session_start();
include("db.php");
include("topnav.php");

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit;
}

// Check if a user ID is provided in the URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;
$user_data = null;

if ($user_id) {
    // Fetch the specific user's data
    $user_result = mysqli_query($mysqli, "SELECT * FROM users WHERE user_id = $user_id");
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);
    }
}

// Handle form submission to update name and role
if (isset($_POST['update_user'])) {
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $role_id = mysqli_real_escape_string($mysqli, $_POST['assigned_role']);

    // Ensure the role exists
    $role_check = mysqli_query($mysqli, "SELECT * FROM roles WHERE role_id = '$role_id'");
    if (mysqli_num_rows($role_check) == 0) {
        echo "<p style='color: red;'>Invalid role selected.</p>";
    } else {
        // Update the user's name and role_id in the users table
        $sql = "UPDATE users SET name = '$name', role_id = '$role_id' WHERE user_id = $user_id";
        if (mysqli_query($mysqli, $sql)) {
            // Redirect to avoid form resubmission
            header("Location: users.php");
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($mysqli);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
    <script src="assets/js/login.js"></script>
</head>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?user_id=" . $user_id); ?>">
        <h5 style="text-align: center">EDIT USER</h5>
        <table class="table table-bordered">
            <tr>
                <td>Enter Name</td>
                <td>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user_data['name'] ?? ''); ?>">
                </td>
            </tr>
            <tr>
                <td>Select Role</td>
                <td>
                    <select name="assigned_role" class="form-select">
                        <option value="">Select role</option>
                        <?php
                        $rolesResult = mysqli_query($mysqli, "SELECT * FROM roles");
                        while ($role = mysqli_fetch_assoc($rolesResult)) {
                            $selected = ($user_data['role_id'] == $role['role_id']) ? "selected" : "";
                            echo "<option value='" . $role['role_id'] . "' $selected>" . $role['role_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="submit" name="update_user" class="btn btn-primary">Save Changes</button>
                </td>
            </tr>
        </table>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>
