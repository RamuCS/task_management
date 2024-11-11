<?php
session_start();
include_once 'function.php';
include_once 'db.php';
include_once 'topnav.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $frequency = $_POST['frequency'];
    $assigned_to= $_POST['assigned_to'];
    $result= mysqli_query($mysqli,"UPDATE predefined_tasks SET title = '$title', description = '$description', frequency = '$frequency', assigned_to = '$assigned_to', updated_at = NOW() WHERE id = '$id'");
    header("Location: addpretask.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADD PREDEFINED TASK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
    <script src="assets/js/login.js"></script>
</head>

<body>

 

            <form method="post">
                <h5 style="text-align: center">EDIT PREDEFINED TASK</h5>
                <table class="table">
                    <tr>
                        <td>Enter Task</td>
                        <td><input type="text" name="title" placeholder="Task Title" ></td>
                    </tr>
                    <tr>
                        <td>Task Description</td>
                        <td><textarea name="description" placeholder="Task Description"></textarea></td>
                    </tr>
                    <tr>
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
                                <option value="">Select User</option>
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
                        <td><input type="reset" name="reset" value="clear" ></td>
                        <td><input type="submit" name="Submit" value="Edit" ></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</body>
</html>

