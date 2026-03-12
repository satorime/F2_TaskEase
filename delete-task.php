<?php
ob_start();
include 'connect.php';

$taskName = $_GET['taskName'];

// Copy task to deleted table
$stmt = $pdo->prepare(
    "INSERT INTO tbltaskdeleted (taskname, taskdescription, taskdate)
     SELECT taskname, taskdescription, taskdate FROM tbltask WHERE taskname = :taskname"
);
$stmt->execute([':taskname' => $taskName]);

// Remove from active tasks
$stmt = $pdo->prepare("DELETE FROM tbltask WHERE taskname = :taskname");
$stmt->execute([':taskname' => $taskName]);

header('Location: dashboard.php');
exit;
?>
