<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $mysqli->prepare("UPDATE active_tasks SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        header("Location: view_active_task.php");
    } else {
        echo "Error updating task status.";
    }
    $stmt->close();
}
?>
