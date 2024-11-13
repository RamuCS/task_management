<?php
include("db.php");
?>
<?php
function addusers($name, $email,$user, $pass){
    global $mysqli;
    $stmt= $mysqli->prepare('INSERT INTO users(name, email ,username,password) values(?,?,?,md5(?))');
    $stmt->bind_param("ssss", $name, $email,$user, $pass);
    $stmt->execute();
    $stmt->close();
}

function addtask($title,$description,$assigned_to)
{
    global $mysqli;
    $stmt= $mysqli->prepare("INSERT INTO tasks(title,description,assigned_to)values(?,?,?) ");
    $stmt->bind_param("sss", $title, $description, $assigned_to);
    $stmt->execute();
    $stmt->close();
}
function addpretask($title,$description,$frequency,$assigned_to)
{
    global $mysqli;
    $stmt= $mysqli->prepare("INSERT INTO predefined_tasks(title,description,frequency,assigned_to,updated_at)values(?,?,?,?,NOW())");
    $stmt->bind_param("ssss", $title, $description,$frequency, $assigned_to);
    $stmt->execute();
    $stmt->close();
}
function edit($id,$title,$description,$frequency,$assigned_to)
{
    global $mysqli;
    $stmt= $mysqli->prepare("UPDATE predefined_tasks SET title = ?, description = ?, frequency = ?, assigned_to = ?, updated_at = NOW() WHERE id = $id");
    $stmt->bind_param("ssssi", $title, $description,$frequency, $assigned_to,$id);
    $stmt->execute();
    $stmt->close();
}
function editPredefined($id, $title, $description, $assigned_to) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE predefined_tasks SET title = ?, description = ?, assigned_to = ? WHERE id = $id");
    $stmt->bind_param("sssi", $title, $description, $assigned_to, $id);
    $stmt->execute();
    $stmt->close();
}
// function.php
function addrole($role_name, $role, $can_create, $can_edit, $can_delete, $can_view, $manager) {
    global $mysqli;

    // Corrected query with placeholders
    $stmt = $mysqli->prepare("INSERT INTO roles (role_name, role, can_create, can_edit, can_delete, can_view, manager) 
            VALUES (?, ?, ?, ?, ?,?,?)");

    // Binding parameters to match the placeholders
    $stmt->bind_param("sssssss", $role_name, $role, $can_create, $can_edit, $can_delete, $can_view,$manager);
    
    // Execute the query
    $stmt->execute();

    // Close the statement
    $stmt->close();
}

?>