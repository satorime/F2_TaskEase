<?php
// Keep-alive endpoint — pings the database so Supabase stays active
// and Render doesn't spin down.
// Register this URL with UptimeRobot or cron-job.org every 5 minutes.
include 'connect.php';

try {
    $pdo->query('SELECT 1');
    echo 'OK';
} catch (PDOException $e) {
    http_response_code(500);
    echo 'DB error';
}
?>
