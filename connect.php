<?php
// ============================================================
// Supabase PostgreSQL Connection
// ============================================================
// Replace the placeholders below with your actual credentials.
// Find them in: Supabase Dashboard → Project Settings → Database
//
//   DB Host     : Settings → Database → Host
//   DB Password : Settings → Database → Database Password
//   Project Ref : the part of your Supabase URL before .supabase.co
// ============================================================

// Credentials are read from environment variables (set these in Render dashboard).
// Use the Supabase Connection Pooler (IPv4, port 6543) to avoid IPv6 issues.
// Find these in: Supabase Dashboard → Project Settings → Database → Connection Pooling
$db_host     = getenv('DB_HOST');
$db_port     = '6543';
$db_name     = 'postgres';
$db_user     = getenv('DB_USER');
$db_password = getenv('DB_PASSWORD');

try {
    $pdo = new PDO(
        "pgsql:host=$db_host;port=$db_port;dbname=$db_name;sslmode=require",
        $db_user,
        $db_password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
