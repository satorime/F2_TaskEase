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
// For local testing, you can set them in your shell or replace getenv() with the raw values.
$db_host     = getenv('DB_HOST');     // e.g. db.abcdefghijklmn.supabase.co
$db_port     = '5432';
$db_name     = 'postgres';
$db_user     = 'postgres';
$db_password = getenv('DB_PASSWORD');

try {
    $pdo = new PDO(
        "pgsql:host=$db_host;port=$db_port;dbname=$db_name",
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
