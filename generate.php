<?php
session_start();
include("db.php");
$result = mysqli_query($mysqli, "SELECT * FROM predefined_tasks");

while ($row = $result->fetch_assoc()) {
    $task_date = date('Y-m-d');
    // $assigned_to = ''; 
    
    $stmt = $mysqli->prepare("INSERT INTO active_tasks (predefined_task_id, status, task_date,  created_at) VALUES (?, 'pending',  ?, NOW())");
    $stmt->bind_param("is", $row['id'], $task_date);
    $stmt->execute();
    
    $stmt->close(); 
}

$mysqli->close(); 
?>
