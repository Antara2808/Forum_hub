<?php
require_once '../config/config.php';
require_once '../app/Core/Helpers.php';

// Test content with various media URLs
$testContent = "
Here's a YouTube video:
https://www.youtube.com/watch?v=dQw4w9WgXcQ

And a Vimeo video:
https://vimeo.com/76979871

Here's an image:
https://picsum.photos/600/400

And a Twitter post:
https://twitter.com/elonmusk/status/1392756522118234117

Here's a regular link:
https://github.com

This is just regular text content.
";

echo "<!DOCTYPE html>
<html>
<head>
    <title>Media Embedding Test</title>
    <script async src=\"https://platform.twitter.com/widgets.js\" charset=\"utf-8\"></script>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .content { border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Media Embedding Test</h1>
    <div class=\"content\">
        " . processContentWithMedia($testContent) . "
    </div>
</body>
</html>";