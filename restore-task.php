<?php
include 'connect.php';

$taskName = $_GET['taskName'];

$sql = "INSERT INTO tblTask (taskname, taskdescription, taskdate)
        SELECT taskname, taskdescription, taskdate FROM tbltaskdeleted WHERE taskname = '$taskName'";

mysqli_query($connection, $sql);

$sql = "DELETE FROM tbltaskdeleted WHERE taskname = '$taskName'";
mysqli_query($connection, $sql);

header('Location: dashboard.php');
exit;
?>