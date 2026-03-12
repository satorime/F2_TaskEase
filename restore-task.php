<?php
ob_start();
include 'connect.php';

$taskName = $_GET['taskName'];

// Restore task back to active table
$stmt = $pdo->prepare(
    "INSERT INTO tbltask (taskname, taskdescription, taskdate)
     SELECT taskname, taskdescription, taskdate FROM tbltaskdeleted WHERE taskname = :taskname"
);
$stmt->execute([':taskname' => $taskName]);

// Remove from deleted table
$stmt = $pdo->prepare("DELETE FROM tbltaskdeleted WHERE taskname = :taskname");
$stmt->execute([':taskname' => $taskName]);

header('Location: dashboard.php');
exit;
?>
