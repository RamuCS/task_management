<?php
session_start();
include("db.php"); // Ensure this connects to the database
include("topnav.php");
include("function.php");

// Saving permissions to an existing role
if (isset($_POST['save_permissions'])) {
    $role_id = $_POST['role_id'];
    $can_create = isset($_POST['can_create']) ? 1 : 0;
    $can_edit = isset($_POST['can_edit']) ? 1 : 0;
    $can_delete = isset($_POST['can_delete']) ? 1 : 0;
    $can_view = isset($_POST['can_view']) ? 1 : 0;
    $manager = isset($_POST['manager']) ? 1 : 0;

    // Update query for permissions
    $update_query = "UPDATE roles SET 
                        can_create='$can_create', 
                        can_edit='$can_edit', 
                        can_delete='$can_delete', 
                        can_view='$can_view', 
                        manager='$manager' 
                    WHERE role_id='$role_id'";
    
    if (mysqli_query($mysqli, $update_query)) {
        echo "<script>alert('Permissions updated successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Error updating permissions: " . mysqli_error($mysqli) . "');</script>";
    }
}

// Handling the form to add a new role
if (isset($_POST['Submit'])) {
    $role_name = $_POST['rolename'];
    $role_desc = $_POST['role'];

    // Insert new role
    $insert_query = "INSERT INTO roles (role_name, role) VALUES ('$role_name', '$role_desc')";
    if (mysqli_query($mysqli, $insert_query)) {
        echo "<script>alert('Role added successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Error adding role: " . mysqli_error($mysqli) . "');</script>";
    }
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
    <link rel="stylesheet" href="assets/css/p.css">
</head>

<body>
    <div class="warp">
        <button id="myBtn1" class="b">ADD ROLE</button>
    </div>
    
    <!-- Modal for adding a role -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h5 style="text-align: center">ADD ROLES</h5>
                <table class="table">
                    <tr>
                        <td>ENTER ROLE</td>
                        <td><input type="text" name="rolename" placeholder="Add Role" required></td>
                    </tr>
                    <tr>
                        <td>ROLE DESCRIPTION</td>
                        <td><input type="text" name="role" placeholder="Describe the role" required></td>
                    </tr>
                    <tr>
                        <td>PERMISSIONS</td>
                        <td>
                            <input type="checkbox" name="can_create" value="1">ADMIN<br>
                            <input type="checkbox" name="can_edit" value="1">WORKER<br>
                            <input type="checkbox" name="can_delete" value="1">MAINTENANCE<br>
                            <input type="checkbox" name="can_view" value="1">HR<br>
                            <input type="checkbox" name="manager" value="1">MANAGER<br>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="reset" name="reset" value="Clear" class="btn btn-secondary"></td>
                        <td><input type="submit" name="Submit" value="Add" class="btn btn-primary"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- Display Existing Roles -->
    <table class="table table-bordered mt-3">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>ROLE</th>
                <th>ROLE NAME</th>
                <th>PERMISSIONS</th>
                <th>GIVE PERMISSION</th>
                <th>EDIT</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($mysqli, "SELECT * FROM roles");
        while ($res = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo $res['role_id']; ?></td>
                <td><?php echo $res['role_name']; ?></td>
                <td><?php echo $res['role']; ?></td>
                <td>
                    <?php
                    echo ($res['can_create'] ? 'ADMIN || ' : '') . 
                         ($res['can_edit'] ? 'WORKER || ' : '') . 
                         ($res['can_delete'] ? 'MAINTENANCE || ' : '') . 
                         ($res['can_view'] ? 'HR ||' : '') .
                         ($res['manager'] ? 'MANAGER' : '');
                    ?>
                </td>
                <td>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="role_id" value="<?php echo $res['role_id']; ?>">
                        <input type="checkbox" name="can_create" <?php echo ($res['can_create'] ? 'checked' : ''); ?>>ADMIN<br>
                        <input type="checkbox" name="can_edit" <?php echo ($res['can_edit'] ? 'checked' : ''); ?>>WORKER<br>
                        <input type="checkbox" name="can_delete" <?php echo ($res['can_delete'] ? 'checked' : ''); ?>>MAINTENANCE<br>
                        <input type="checkbox" name="can_view" <?php echo ($res['can_view'] ? 'checked' : ''); ?>>HR<br>
                        <input type="checkbox" name="manager" <?php echo ($res['manager'] ? 'checked' : ''); ?>>MANAGER<br>
                        <input type="submit" name="save_permissions" value="Save" class="btn btn-success">
                    </form>
                </td>
                <td>
                    <a href="editroles.php?role_id=<?php echo $res['role_id']; ?>">Edit</a> | 
                    <a href="deleteroles.php?role_id=<?php echo $res['role_id']; ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- JavaScript for Modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn1");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script type="text/javascript">
    // Prevent the back button from functioning after logout
    window.history.forward();
    function noBack() { window.history.forward(); }
    window.onload = noBack;
    window.onpageshow = function(evt) { if (evt.persisted) noBack(); }
</script>

</body>
</html>
