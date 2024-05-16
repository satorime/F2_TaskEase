<?php
include 'connect.php';

$taskName = $_GET['taskName'];

$sql = "UPDATE tbltaskdeleted SET is_active = 0 WHERE taskname='$taskName'";
$result = mysqli_query($connection, $sql);

if ($result) {
    echo "Task deactivated successfully!";
} else {
    echo "Error deactivating task: ". mysqli_error($connection);
}

header('Location: dashboard.php');
exit;
?>