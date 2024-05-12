<?php
include 'connect.php';
 
    $taskName = $_GET['taskName'];
 
    $sql = "DELETE FROM tbltaskdeleted WHERE taskname='$taskName'";
    $result = mysqli_query($connection, $sql);
 
    if ($result) {
        echo "Task deleted successfully!";
    } else {
        echo "Error deleting task: " . mysqli_error($connection);
    }
 
    header('Location: dashboard.php');
    exit;
?>