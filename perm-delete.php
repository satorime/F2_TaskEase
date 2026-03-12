<?php
include 'connect.php';

$taskName = $_GET['taskName'];

// Permanently hide the task by marking it inactive
$stmt = $pdo->prepare("UPDATE tbltaskdeleted SET is_active = 0 WHERE taskname = :taskname");
$result = $stmt->execute([':taskname' => $taskName]);

if (!$result) {
    echo "Error deactivating task.";
}

header('Location: dashboard.php');
exit;
?>
