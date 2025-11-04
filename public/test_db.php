<?php
// Test database connection and required tables
require_once '../config/config.php';

echo "<h1>Database Test</h1>";

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Check if thread_likes table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'thread_likes'");
    $tableExists = $stmt->fetch();
    
    if ($tableExists) {
        echo "<p style='color: green;'>✓ thread_likes table exists.</p>";
    } else {
        echo "<p style='color: red;'>✗ thread_likes table does not exist.</p>";
        echo "<p>You need to run the database migration to add this table.</p>";
    }
    
    // Check if likes_count column exists in threads table
    $stmt = $pdo->query("SHOW COLUMNS FROM threads LIKE 'likes_count'");
    $columnExists = $stmt->fetch();
    
    if ($columnExists) {
        echo "<p style='color: green;'>✓ likes_count column exists in threads table.</p>";
    } else {
        echo "<p style='color: red;'>✗ likes_count column does not exist in threads table.</p>";
        echo "<p>You need to run the database migration to add this column.</p>";
    }
    
    // List all tables
    echo "<h2>Database Tables</h2>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>" . reset($table) . "</li>";
    }
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "<p><a href='/ForumHub/public/'>Back to ForumHub</a></p>";
?>