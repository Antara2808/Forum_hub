<?php
require_once '../config/config.php';
require_once '../app/Core/Database.php';
require_once '../app/Core/Helpers.php';

try {
    // Connect to database
    $db = \Core\Database::getInstance()->getConnection();
    
    // Test query to get a sample thread
    $stmt = $db->prepare("SELECT id, title, content FROM threads LIMIT 1");
    $stmt->execute();
    $thread = $stmt->fetch();
    
    if ($thread) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Database Media Embedding Test</title>
            <script async src=\"https://platform.twitter.com/widgets.js\" charset=\"utf-8\"></script>
            <style>
                body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
                .content { border: 1px solid #ddd; padding: 20px; border-radius: 5px; margin-top: 20px; }
                .test-input { background: #f5f5f5; padding: 15px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <h1>Database Media Embedding Test</h1>
            <div class=\"test-input\">
                <h2>Original Content from Database:</h2>
                <p><strong>Title:</strong> " . htmlspecialchars($thread['title']) . "</p>
                <p><strong>Content:</strong></p>
                <pre>" . htmlspecialchars($thread['content']) . "</pre>
            </div>
            <div class=\"content\">
                <h2>Processed Content with Media Embedding:</h2>
                " . processContentWithMedia($thread['content']) . "
            </div>
        </body>
        </html>";
    } else {
        echo "No threads found in database. Please create some sample content first.";
    }
} catch (Exception $e) {
    echo "Database connection error: " . $e->getMessage();
}