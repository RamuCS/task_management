<?php session_start();
include("db.php");
include("topnav.php");
include("function.php");
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];

    
    


    // checking empty fields
    if (empty($title) || empty($description) ||  empty($assigned_to)) {
        if (empty($title)) {
            echo "<font color='red'>Title field is empty.</font><br/>";
        }

        if (empty($description)) {
            echo "<font color='red'>Description field is empty.</font><br/>";
        }
        if (empty($assigned_to)) {
            echo "<font color='red'>Assign field is empty.</font><br/>";
        }
        
    } else {
        addtask($title,$description,$assigned_to);
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
    <title>Instance task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
    <script src="assets/js/login.js"></script>
</head>

<body>
    <div class="warp">
        <button id="myBtn1" class="b">INSTANCE TASK</button>
    </div>



    <table style="margin-top : 20px; margin-left: auto; marigin-right: auto; margin-bottom:20px">
        <tr bgcolor='#CCCCCC'>
            <th>ID</th>
            <th>TITLE</th>
            <th>DESCRIPTION</th>
            <th>ASSIGNED_TO</th>
            <th>CREATED_AT</th>
            <th>UPDATE</th>
        </tr>
        <?php
        $result = mysqli_query($mysqli, "SELECT * FROM tasks");
        ?>
        <?php while ($res = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo $res['id']; ?></td>
                <td><?php echo $res['title']; ?></td>
                <td><?php echo $res['description']; ?></td>
                <td><?php echo $res['assigned_to']?></td>
                <td><?php echo $res['created_at']?></td>
                <td><a href="edittask.php?id=<?php echo $res['id']; ?>">Edit</a> |
                    <a href="addelete.php?id=<?php echo $res['id']; ?>"
                        onClick="return confirm('Are you sure you want to delete?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
           <form method="post">
            <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>

            <h5 style="text-align: center">ADD INSTANCE TASK</h5>
                <table>
                    <tr>
                        <td> Enter Task</td>
                        <td><input type="text" name="title" placeholder="Task Title" required></td>
                    </tr>
                    <tr>
                        <td>Task Description</td>
                        <td><textarea name="description" placeholder="Task Description" required></textarea></td>
                    <tr>
                        <td>ASSIGNED_TO</td>
                        <td>
                            <select name="assigned_to">
                                <option value="">Select User</option>
                                <?php
                                $result = mysqli_query($mysqli, "SELECT * FROM users WHERE approval =1");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . htmlspecialchars($row["name"]) . "'>" . htmlspecialchars($row["name"]) .   "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><input type="reset" name="reset" value="clear" class="b btn-success"></td>
                        <td><input type="submit" name="Submit" value="Add" class="b btn-success"></td>

                    </tr>

                </table>
            </form>


        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
</body>
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

</html>