<?php
session_start();
include_once 'function.php';
include_once 'db.php';
include_once 'topnav.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];
    $result= mysqli_query($mysqli,"UPDATE tasks SET id ='$id',title = '$title',description = '$description',assigned_to = '$assigned_to'");
    header("Location: addtasks.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDIT PREDEFINED TASK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
    <script src="assets/js/login.js"></script>
</head>

<body>

   

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h5 style="text-align: center">EDIT INSTANCE TASK</h5>
                <table class="table">
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="id"></td>
                    </tr>
                    <tr>
                        <td>Enter Task</td>
                        <td><input type="text" name="title" placeholder="Task Title" required></td>
                    </tr>
                    <tr>
                        <td>Task Description</td>
                        <td><textarea name="description" placeholder="Task Description"></textarea></td>
                    </tr>
                    <tr>
                        <td>ASSIGNED_TO</td>
                        <td>
                            <select name="assigned_to">
                                <option >Select User</option>
                                <?php
                                $result = mysqli_query($mysqli, "SELECT * FROM users");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . htmlspecialchars($row["name"]) . "'>" . htmlspecialchars($row["name"]) . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="reset" name="reset" value="clear" ></td>
                        <td><input type="submit" name="Submit" value="Add" ></td>
                    </tr>
                </table>
            </form>
        </div>

    
</body>
</html>

