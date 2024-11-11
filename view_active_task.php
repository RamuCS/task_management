<?php
include("db.php");
include("topnav.php");
include("function.php");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/p.css">
    <script src="assets/js/login.js"></script>
</head>

<body>
    <main class="content" id="main-content">
        <button class="col-3"><a href="daily.php">VIEW DAILY TASK</a></button>
        <button class="col-3"><a href="weekly.php">VIEW WEEKLY TASK</a></button>
        <button class="col-3"><a href="monthly.php">VIEW MONTHLY TASK</a></button>
        <table>
          
                <tr>
                    <th class="col-2">ID</th>
                    <th class="col-2">Task Title</th>
                    <th class="col-2">Description</th>
                    <th class="col-2">Assigned_to</th>
                    <th class="col-2">Status</th>
                    <th class="col-2">Update Status</th>

                </tr>
       

        <?php
        $result = mysqli_query($mysqli, "SELECT active_tasks.id AS active_tasks_id, active_tasks.id,predefined_tasks.title,predefined_tasks.description,predefined_tasks.assigned_to, active_tasks.status FROM active_tasks JOIN predefined_tasks ON active_tasks.predefined_task_id = predefined_tasks.id WHERE task_date = CURDATE()");
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" .htmlspecialchars($row["id"]) ."</td>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["assigned_to"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
            echo "<td>";
            if($row['status'] == 'pending'){
                echo "<form method='post' action='update_status.php'>";
                        echo "<input type='hidden' name='id' value='" . $row['active_tasks_id'] . "'>";
                        echo "<input type='hidden' name='status' value='completed'>";
                        echo "<input type='submit' value='Mark as Completed'>";
                        echo "</form>";
            }else{
                echo "Completed";
            }
                
            echo"</td>";
            echo "</tr>";
        }
        ?>
        </table>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
            crossorigin="anonymous"></script>
</body>

</html>