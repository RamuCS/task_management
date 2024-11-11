<?php session_start();
include("db.php");
include("topnav.php");
include("function.php");
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $frequency = $_POST['frequency'];
    $assigned_to = $_POST['assigned_to'];
   

    // checking empty fields
    if (empty($title) || empty($description) || empty($frequency)) {
        if (empty($title)) {
            echo "<font color='red'>Title field is empty.</font><br/>";
        }

        if (empty($description)) {
            echo "<font color='red'>Description field is empty.</font><br/>";
        }
        if (empty($frequency)) {
            echo "<font color='red'>Frequency field is empty.</font><br/>";
        }
    } else {
        addpretask($title, $description, $frequency, $assigned_to);
        echo "<script type='text/javascript'>
        alert('Submitted successfully!');
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
    <title> PREDEFINED TASK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
    <script src="assets/js/login.js"></script>
   
</head>

<body>

    <div class="warp">
        <button id="myBtn1" class="b">ADD PREDEFINED TASK</button>
    </div>
    
    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h5></h5>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h5 style="text-align: center">ADD PREDEFINED TASK</h5>
                <table class="table">
                    <tr>
                        <td>Enter Task</td>
                        <td><input type="text" name="title" placeholder="Task Title" required></td>
                    </tr>
                    <tr>
                        <td>Task Description</td>
                        <td><textarea name="description" placeholder="Task Description"></textarea></td>
                    </tr>
                        <td>Task Frequency</td>
                        <td>
                            <select name="frequency">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>ASSIGNED_TO</td>
                        <td>
                            <select name="assigned_to">
                                <option value="">Select role</option>
                                <?php
                                $result = mysqli_query($mysqli, "SELECT * FROM users");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . htmlspecialchars($row["roles"]) . "'>" . htmlspecialchars($row["roles"]) . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="reset" name="reset" value="clear" class="b btn-success" ></td>
                        <td><input type="submit" name="Submit" value="Add" class="b btn-success" ></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <table class="table table-bordered mt-3">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>TITLE</th>
                <th>DESCRIPTION</th>
                <th>FREQUENCY</th>
                <th>CREATED_AT</th>
                <th>TASK ASSIGNED</th>
                <th>UPDATE</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($mysqli, "SELECT * FROM predefined_tasks");
        while ($res = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo $res['id']; ?></td>
                <td><?php echo $res['title']; ?></td>
                <td><?php echo $res['description']; ?></td>
                <td><?php echo $res['frequency']; ?></td>
                <td><?php echo $res['created_at']?></td>
                <td><?php echo $res['assigned_to']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $res['id'];?>">Edit</a> |
                    <a href="addelete.php?id=<?php echo $res['id']; ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
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
