<?php
include 'connect.php';

$taskname = $_POST['taskname'];
$taskdate = $_POST['taskdate'];
$taskdescription = $_POST['taskdescription'];

$sql = "INSERT into tblimportanttask(taskname, taskdescription, taskdate) values('$taskname', '$taskdescription', '$taskdate')";
mysqli_query($connection, $sql);

echo "Task marked as important.";
?>