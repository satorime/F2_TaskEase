<?php
include 'connect.php';

$taskname        = $_POST['taskname'];
$taskdate        = $_POST['taskdate'];
$taskdescription = $_POST['taskdescription'];

$stmt = $pdo->prepare(
    "INSERT INTO tblimportanttask (taskname, taskdescription, taskdate)
     VALUES (:taskname, :taskdescription, :taskdate)"
);
$stmt->execute([
    ':taskname'        => $taskname,
    ':taskdescription' => $taskdescription,
    ':taskdate'        => $taskdate,
]);

echo "Task marked as important.";
?>
