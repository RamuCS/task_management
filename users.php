<?php
session_start();
include("db.php");
include("topnav.php");

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit;
}

// Fetch all users with their roles using a JOIN query
$query = "SELECT users.user_id, users.name, users.email, users.approval, users.role_id, roles.role_name 
          FROM users 
          LEFT JOIN roles ON users.role_id = roles.role_id";
$result = mysqli_query($mysqli, $query);

// Fetch all available roles for the dropdown
$roles_result = mysqli_query($mysqli, "SELECT * FROM roles");
$roles = [];
while ($role = mysqli_fetch_assoc($roles_result)) {
    $roles[$role['role_id']] = $role['role_name'];
}

// Handle toggle button click (approval status update)
if (isset($_GET['user_id'])) {
    $id = intval($_GET['user_id']); // Ensure the id is an integer
    $result = mysqli_query($mysqli, "SELECT approval FROM users WHERE user_id='$id'");
    if ($result && mysqli_num_rows($result) > 0) {
        $current_status = mysqli_fetch_assoc($result)['approval'];
        $new_status = ($current_status == 1) ? 0 : 1; // Toggle between 0 and 1

        $sql = "UPDATE users SET approval=$new_status WHERE user_id='$id'";
        if (mysqli_query($mysqli, $sql)) {
            // Successful update, redirect to avoid resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($mysqli);
        }
    }
}

// Handle form submission to update roles
if (isset($_POST['update_roles'])) {
    foreach ($_POST['assigned_role'] as $user_id => $role_id) {
        $role_id = mysqli_real_escape_string($mysqli, $role_id);

        // Ensure the role_id is not empty
        if (!empty($role_id)) {
            $sql = "UPDATE users SET role_id = '$role_id' WHERE user_id = '$user_id'";
            mysqli_query($mysqli, $sql);
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to avoid form resubmission
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ROLES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css"></head>
    <script>
        window.history.forward();
    </script>

    <body>

<main class="content" id="main-content">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <button type="submit" name="update_roles" class="btn btn-primary mb-3">Save Roles</button>

        <table class="table">
            <thead>
                <tr bgcolor='#CCCCCC'>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Update</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each user and display details
                while ($res = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $res['user_id'] . "</td>";
                    echo "<td>" . $res['name'] . "</td>";
                    echo "<td>" . $res['email'] . "</td>";

                    // Role selection dropdown
                    echo "<td>";
                    echo "<select name='assigned_role[" . $res['user_id'] . "]'>";
                    foreach ($roles as $role_id => $role_name) {
                        $selected = ($res['role_id'] == $role_id) ? "selected" : "";
                        echo "<option value='$role_id' $selected>$role_name</option>";
                    }
                    echo "</select>";
                    echo "</td>";

                    // Approval Status: 1 (Active), 0 (Inactive)
                    echo "<td>" . ($res['approval'] == 1 ? "Active" : "Inactive") . "</td>";
                    echo "<td>";
                    if ($res['approval'] == 1) {
                        echo "<a href='?user_id=" . $res['user_id'] . "' class='btn btn-danger'>Deactivate</a>";
                    } else {
                        echo "<a href='?user_id=" . $res['user_id'] . "' class='btn btn-success'>Activate</a>";
                    }
                    echo "</td>";

                    // Edit and Delete links
                    echo "<td><a href=\"uedit.php?user_id={$res['user_id']}\">Edit</a> | <a href=\"delete.php?user_id={$res['user_id']}\" onClick=\"return confirm('Are you sure you want to delete? id = {$res['user_id']} name = {$res['name']}')\">Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </form>
</main>
<script>
    window.addEventListener("pageshow", function(event) {
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
        // Check session via AJAX or using sessionStorage
        if (!sessionStorage.getItem("user")) {
            window.location.href = "login.php";
        }
    }
});


</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>
