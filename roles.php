<?php
session_start();
include("db.php");
include("topnav.php");
include("function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['rolename'];
    $role = $_POST['role'];
    $can_create = isset($_POST['can_create']) ? 1 : 0;
    $can_edit = isset($_POST['can_edit']) ? 1 : 0;
    $can_delete = isset($_POST['can_delete']) ? 1 : 0;
    $can_view = isset($_POST['can_view']) ? 1 : 0;

    if (empty($title)) {
        echo "<font color='red'>Role field is empty.</font><br/>";
    } 
    if (empty($role)) {
        echo "<font color='red'>Role field is empty.</font><br/>";
    } else {
        // Call the function to add role with permissions
        addrole($title, $role, $can_create, $can_edit, $can_delete, $can_view);
        echo "<script type='text/javascript'>
        alert('Role added successfully!');
        window.location = '" . $_SERVER['PHP_SELF'] . "';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Predefined Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
</head>

<body>
    <div class="warp">
        <button id="myBtn1" class="b">ADD ROLE</button>
    </div>
    
    <!-- Modal -->
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
                        <td>Permissions</td>
                        <td>
                            <input type="checkbox" name="can_create" value="1">ADMIN<br>
                            <input type="checkbox" name="can_edit" value="1">MANAGER<br>
                            <input type="checkbox" name="can_delete" value="1">ALL <br>
                            <input type="checkbox" name="can_view" value="1">WORKER<br>
                            <input type="checkbox" name="can_view" value="1">MAINTANANCE<br>
                            
                        </td>
                    </tr>
                    <tr>
                        <td><input type="reset" name="reset" value="Clear" class="b btn-success"></td>
                        <td><input type="submit" name="Submit" value="Add" class="b btn-success"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- Displaying Existing Roles -->
    <table class="table table-bordered mt-3">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>ROLE</th>
                <th>ROLE NAME</th>
                <th>PERMISSIONS</th>
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
                    echo ($res['can_create'] ? 'Can Create, ' : '') . 
                         ($res['can_edit'] ? 'Can Edit, ' : '') . 
                         ($res['can_delete'] ? 'Can Delete, ' : '') . 
                         ($res['can_view'] ? 'Can View' : '');
                    ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

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
</body>
</html>
