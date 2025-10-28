<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForumHub Pro - Installation Checker</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #667eea;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .check-item {
            padding: 1rem;
            margin: 0.5rem 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .check-item.success {
            background: #d4edda;
            border-left: 4px solid #28a745;
        }
        .check-item.error {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .check-item.warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
        }
        .status {
            font-weight: bold;
            font-size: 1.2rem;
        }
        .success .status { color: #28a745; }
        .error .status { color: #dc3545; }
        .warning .status { color: #ffc107; }
        .button {
            display: inline-block;
            padding: 1rem 2rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            margin-top: 2rem;
            font-weight: bold;
            transition: all 0.3s;
        }
        .button:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .summary {
            padding: 1.5rem;
            background: #e7f3ff;
            border-radius: 10px;
            margin: 1.5rem 0;
            border-left: 4px solid #667eea;
        }
        .code {
            background: #f4f4f4;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            <span style="font-size: 2rem;">🔍</span>
            ForumHub Pro Installation Checker
        </h1>
        
        <div class="summary">
            <strong>Quick Status:</strong> This page checks your ForumHub Pro installation.
        </div>

        <?php
        $checks = [];
        $errors = 0;
        $warnings = 0;
        
        // Check PHP version
        $phpVersion = phpversion();
        if (version_compare($phpVersion, '7.4.0', '>=')) {
            $checks[] = ['success', 'PHP Version', "PHP $phpVersion ✓"];
        } else {
            $checks[] = ['error', 'PHP Version', "PHP $phpVersion (Need 7.4+)"];
            $errors++;
        }
        
        // Check required extensions
        $required = ['pdo', 'pdo_mysql', 'mbstring', 'json'];
        foreach ($required as $ext) {
            if (extension_loaded($ext)) {
                $checks[] = ['success', "Extension: $ext", "Loaded ✓"];
            } else {
                $checks[] = ['error', "Extension: $ext", "Missing ✗"];
                $errors++;
            }
        }
        
        // Check config file
        if (file_exists('../config/config.php')) {
            $checks[] = ['success', 'Config File', 'Found ✓'];
        } else {
            $checks[] = ['error', 'Config File', 'Missing ✗'];
            $errors++;
        }
        
        // Check database connection
        try {
            require_once '../config/config.php';
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            $checks[] = ['success', 'Database Connection', 'Connected ✓'];
            
            // Check tables
            $tables = ['users', 'threads', 'posts', 'categories'];
            $stmt = $pdo->query("SHOW TABLES");
            $existingTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            foreach ($tables as $table) {
                if (in_array($table, $existingTables)) {
                    $checks[] = ['success', "Table: $table", 'Exists ✓'];
                } else {
                    $checks[] = ['error', "Table: $table", 'Missing ✗'];
                    $errors++;
                }
            }
            
            // Check sample data
            $stmt = $pdo->query("SELECT COUNT(*) FROM users");
            $userCount = $stmt->fetchColumn();
            if ($userCount > 0) {
                $checks[] = ['success', 'Sample Data', "$userCount users found ✓"];
            } else {
                $checks[] = ['warning', 'Sample Data', 'No users found'];
                $warnings++;
            }
            
        } catch (PDOException $e) {
            $checks[] = ['error', 'Database Connection', $e->getMessage()];
            $errors++;
        }
        
        // Check upload directories
        $uploadDirs = ['avatars', 'files', 'banners'];
        foreach ($uploadDirs as $dir) {
            $path = "../public/uploads/$dir";
            if (is_dir($path)) {
                if (is_writable($path)) {
                    $checks[] = ['success', "Upload Dir: $dir", 'Writable ✓'];
                } else {
                    $checks[] = ['warning', "Upload Dir: $dir", 'Not writable'];
                    $warnings++;
                }
            } else {
                $checks[] = ['error', "Upload Dir: $dir", 'Missing ✗'];
                $errors++;
            }
        }
        
        // Check .htaccess files
        if (file_exists('../.htaccess')) {
            $checks[] = ['success', 'Root .htaccess', 'Found ✓'];
        } else {
            $checks[] = ['warning', 'Root .htaccess', 'Missing (optional)'];
            $warnings++;
        }
        
        if (file_exists('.htaccess')) {
            $checks[] = ['success', 'Public .htaccess', 'Found ✓'];
        } else {
            $checks[] = ['error', 'Public .htaccess', 'Missing ✗'];
            $errors++;
        }
        
        // Display checks
        foreach ($checks as $check) {
            [$status, $name, $message] = $check;
            echo "<div class='check-item $status'>";
            echo "<span><strong>$name:</strong> $message</span>";
            echo "<span class='status'>" . ($status === 'success' ? '✓' : ($status === 'error' ? '✗' : '⚠')) . "</span>";
            echo "</div>";
        }
        ?>
        
        <div class="summary">
            <?php if ($errors === 0 && $warnings === 0): ?>
                <strong style="color: #28a745;">✓ Perfect!</strong> Your installation is complete and ready to use!
            <?php elseif ($errors === 0): ?>
                <strong style="color: #ffc107;">⚠ Good!</strong> Installation works but has <?php echo $warnings; ?> warning(s).
            <?php else: ?>
                <strong style="color: #dc3545;">✗ Issues Found!</strong> Please fix <?php echo $errors; ?> error(s) before using ForumHub.
            <?php endif; ?>
        </div>
        
        <?php if ($errors === 0): ?>
        <a href="/" class="button">🚀 Launch ForumHub Pro</a>
        <?php else: ?>
        <div style="margin-top: 1.5rem; padding: 1rem; background: #fff3cd; border-radius: 10px;">
            <strong>Fix Issues:</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                <li>Make sure MySQL is running</li>
                <li>Import <span class="code">database/forumhub_mvc.sql</span></li>
                <li>Import <span class="code">database/sample_data.sql</span></li>
                <li>Check folder permissions</li>
            </ul>
        </div>
        <?php endif; ?>
        
        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #ddd; color: #666; font-size: 0.9rem;">
            <strong>Documentation:</strong>
            <a href="../README.md" style="color: #667eea; margin-left: 1rem;">README</a> |
            <a href="../SETUP.md" style="color: #667eea; margin-left: 0.5rem;">Setup Guide</a> |
            <a href="../QUICKSTART.md" style="color: #667eea; margin-left: 0.5rem;">Quick Start</a>
        </div>
    </div>
</body>
</html>
