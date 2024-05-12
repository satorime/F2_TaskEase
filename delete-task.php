<?php
include 'connect.php';

$taskName = $_GET['taskName'];

$sql = "INSERT INTO tbltaskdeleted (taskname, taskdescription, taskdate)
        SELECT taskname, taskdescription, taskdate FROM tblTask WHERE taskname = '$taskName'";

mysqli_query($connection, $sql);

$sql = "DELETE FROM tblTask WHERE taskname = '$taskName'";
mysqli_query($connection, $sql);

header('Location: dashboard.php');
exit;
?>