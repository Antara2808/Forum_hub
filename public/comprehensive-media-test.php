<?php
require_once '../config/config.php';
require_once '../app/Core/Database.php';
require_once '../app/Core/Helpers.php';

// Create a test thread with media content
$testContent = "
Welcome to our forum! Here are some examples of media embedding:

**YouTube Video:**
Check out this amazing video: https://www.youtube.com/watch?v=dQw4w9WgXcQ

**Vimeo Video:**
Here's a great Vimeo video: https://vimeo.com/76979871

**Image:**
Beautiful landscape: https://picsum.photos/800/400

**Twitter Post:**
Interesting tweet: https://twitter.com/elonmusk/status/1392756522118234117

**Regular Link:**
Visit our GitHub repo: https://github.com

This is just regular text with some **bold** and *italic* formatting.
";

try {
    // Connect to database
    $db = \Core\Database::getInstance()->getConnection();
    
    // Insert test thread
    $stmt = $db->prepare("INSERT INTO threads (user_id, category_id, title, slug, content) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([1, 1, 'Media Embedding Test Thread', 'media-embedding-test', $testContent]);
    $threadId = $db->lastInsertId();
    
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Comprehensive Media Embedding Test</title>
        <script async src=\"https://platform.twitter.com/widgets.js\" charset=\"utf-8\"></script>
        <style>
            body { font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
            .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
            .original { background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #007bff; }
            .processed { background: #fff; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #28a745; }
            h1, h2 { color: #333; }
            pre { background: #f1f1f1; padding: 15px; border-radius: 5px; overflow-x: auto; }
            .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
            .btn:hover { background: #0056b3; }
        </style>
    </head>
    <body>
        <div class=\"container\">
            <h1>Comprehensive Media Embedding Test</h1>
            <p>This test demonstrates the media embedding functionality with database integration.</p>
            
            <a href=\"media-embedding-test.php\" class=\"btn\">View Simple Test</a>
            <a href=\"db-media-test.php\" class=\"btn\">View Database Test</a>
            
            <div class=\"original\">
                <h2>Original Content (Before Processing)</h2>
                <pre>" . htmlspecialchars($testContent) . "</pre>
            </div>
            
            <div class=\"processed\">
                <h2>Processed Content (With Media Embedding)</h2>
                " . processContentWithMedia($testContent) . "
            </div>
            
            <div class=\"original\">
                <h2>Test Thread Created in Database</h2>
                <p>Thread ID: " . $threadId . "</p>
                <p><strong>Note:</strong> This test thread has been added to your database for demonstration purposes.</p>
            </div>
        </div>
    </body>
    </html>";
    
} catch (Exception $e) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Media Embedding Test Error</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
            .error { background: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; border: 1px solid #f5c6cb; }
        </style>
    </head>
    <body>
        <div class=\"error\">
            <h2>Database Error</h2>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
        </div>
    </body>
    </html>";
}