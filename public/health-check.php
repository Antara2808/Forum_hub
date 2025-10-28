<?php
/**
 * ForumHub Health Check
 * Comprehensive system diagnostics
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use Core\Database;

$results = [];
$errors = [];
$warnings = [];

// Check 1: PHP Version
$results['php_version'] = [
    'status' => version_compare(PHP_VERSION, '7.4.0', '>=') ? 'success' : 'error',
    'value' => PHP_VERSION,
    'required' => '7.4+',
    'message' => version_compare(PHP_VERSION, '7.4.0', '>=') ? 'PHP version is compatible' : 'PHP version too old'
];

// Check 2: Required Extensions
$required_extensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'session'];
$extension_status = [];
foreach ($required_extensions as $ext) {
    $loaded = extension_loaded($ext);
    $extension_status[$ext] = $loaded;
    if (!$loaded) {
        $errors[] = "Missing required extension: $ext";
    }
}
$results['extensions'] = [
    'status' => empty($errors) ? 'success' : 'error',
    'value' => $extension_status,
    'message' => empty($errors) ? 'All required extensions loaded' : implode(', ', $errors)
];

// Check 3: Database Connection
try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    $stmt = $pdo->query("SELECT 1");
    $results['database'] = [
        'status' => 'success',
        'value' => DB_HOST . ':' . DB_NAME,
        'message' => 'Database connection successful'
    ];
} catch (Exception $e) {
    $results['database'] = [
        'status' => 'error',
        'value' => DB_HOST . ':' . DB_NAME,
        'message' => 'Database connection failed: ' . $e->getMessage()
    ];
    $errors[] = 'Database connection failed';
}

// Check 4: Required Directories
$required_dirs = [
    'public/uploads' => PUBLIC_PATH . '/uploads',
    'public/uploads/avatars' => PUBLIC_PATH . '/uploads/avatars',
    'public/uploads/banners' => PUBLIC_PATH . '/uploads/banners',
    'logs' => ROOT_PATH . '/logs'
];
$dir_status = [];
foreach ($required_dirs as $name => $path) {
    $exists = file_exists($path);
    $writable = $exists && is_writable($path);
    $dir_status[$name] = [
        'exists' => $exists,
        'writable' => $writable
    ];
    if (!$exists) {
        $warnings[] = "Directory missing: $name";
    } elseif (!$writable) {
        $warnings[] = "Directory not writable: $name";
    }
}
$results['directories'] = [
    'status' => empty($warnings) ? 'success' : 'warning',
    'value' => $dir_status,
    'message' => empty($warnings) ? 'All directories OK' : implode(', ', $warnings)
];

// Check 5: Core Files
$core_files = [
    'Router' => APP_PATH . '/Core/Router.php',
    'Database' => APP_PATH . '/Core/Database.php',
    'Controller' => APP_PATH . '/Core/Controller.php',
    'Model' => APP_PATH . '/Core/Model.php',
    'Helpers' => APP_PATH . '/Core/Helpers.php',
];
$file_status = [];
$missing_files = [];
foreach ($core_files as $name => $path) {
    $exists = file_exists($path);
    $file_status[$name] = $exists;
    if (!$exists) {
        $missing_files[] = $name;
        $errors[] = "Missing core file: $name";
    }
}
$results['core_files'] = [
    'status' => empty($missing_files) ? 'success' : 'error',
    'value' => $file_status,
    'message' => empty($missing_files) ? 'All core files present' : 'Missing: ' . implode(', ', $missing_files)
];

// Check 6: Configuration
$config_issues = [];
if (!defined('DB_HOST') || empty(DB_HOST)) $config_issues[] = 'DB_HOST not configured';
if (!defined('DB_NAME') || empty(DB_NAME)) $config_issues[] = 'DB_NAME not configured';
if (!defined('BASE_URL') || empty(BASE_URL)) $config_issues[] = 'BASE_URL not configured';
if (!defined('APP_URL') || empty(APP_URL)) $config_issues[] = 'APP_URL not configured';

$results['configuration'] = [
    'status' => empty($config_issues) ? 'success' : 'error',
    'value' => [
        'DB_HOST' => defined('DB_HOST') ? DB_HOST : 'NOT SET',
        'DB_NAME' => defined('DB_NAME') ? DB_NAME : 'NOT SET',
        'BASE_URL' => defined('BASE_URL') ? BASE_URL : 'NOT SET',
        'ENVIRONMENT' => ENVIRONMENT
    ],
    'message' => empty($config_issues) ? 'Configuration OK' : implode(', ', $config_issues)
];

// Check 7: Database Tables
try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    $required_tables = ['users', 'threads', 'posts', 'categories', 'messages', 'events'];
    $table_status = [];
    foreach ($required_tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        $result = $stmt->fetchAll();
        $exists = count($result) > 0;
        $table_status[$table] = $exists;
        if (!$exists) {
            $errors[] = "Missing database table: $table";
        }
    }
    $results['database_tables'] = [
        'status' => count($table_status) === count($required_tables) ? 'success' : 'error',
        'value' => $table_status,
        'message' => count($table_status) === count($required_tables) ? 'All tables present' : 'Some tables missing'
    ];
} catch (Exception $e) {
    $results['database_tables'] = [
        'status' => 'error',
        'value' => [],
        'message' => 'Could not check tables: ' . $e->getMessage()
    ];
}

// Check 8: Session
session_status() === PHP_SESSION_ACTIVE ? session_write_close() : null;
session_start();
$_SESSION['health_check'] = 'OK';
$session_works = isset($_SESSION['health_check']);
$results['session'] = [
    'status' => $session_works ? 'success' : 'error',
    'value' => session_id(),
    'message' => $session_works ? 'Session working' : 'Session not working'
];

// Overall Status
$overall_status = 'success';
if (count($errors) > 0) {
    $overall_status = 'error';
} elseif (count($warnings) > 0) {
    $overall_status = 'warning';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForumHub Health Check</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                        ForumHub Health Check
                    </h1>
                    <p class="text-gray-600 mt-1">System Diagnostics & Status</p>
                </div>
                <div class="text-center">
                    <?php if ($overall_status === 'success'): ?>
                        <div class="text-6xl text-green-500"><i class="fas fa-check-circle"></i></div>
                        <p class="text-green-600 font-bold mt-2">All Systems GO!</p>
                    <?php elseif ($overall_status === 'warning'): ?>
                        <div class="text-6xl text-yellow-500"><i class="fas fa-exclamation-triangle"></i></div>
                        <p class="text-yellow-600 font-bold mt-2">Minor Issues</p>
                    <?php else: ?>
                        <div class="text-6xl text-red-500"><i class="fas fa-times-circle"></i></div>
                        <p class="text-red-600 font-bold mt-2">Errors Found</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-3xl text-green-600 mr-3"></i>
                    <div>
                        <p class="text-green-800 font-bold text-2xl"><?php echo count(array_filter($results, fn($r) => $r['status'] === 'success')); ?></p>
                        <p class="text-green-700 text-sm">Passed</p>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-3xl text-yellow-600 mr-3"></i>
                    <div>
                        <p class="text-yellow-800 font-bold text-2xl"><?php echo count($warnings); ?></p>
                        <p class="text-yellow-700 text-sm">Warnings</p>
                    </div>
                </div>
            </div>
            <div class="bg-red-100 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-times-circle text-3xl text-red-600 mr-3"></i>
                    <div>
                        <p class="text-red-800 font-bold text-2xl"><?php echo count($errors); ?></p>
                        <p class="text-red-700 text-sm">Errors</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Results -->
        <div class="space-y-4">
            <?php foreach ($results as $check => $result): ?>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">
                            <?php if ($result['status'] === 'success'): ?>
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <?php elseif ($result['status'] === 'warning'): ?>
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                            <?php else: ?>
                                <i class="fas fa-times-circle text-red-500 mr-2"></i>
                            <?php endif; ?>
                            <?php echo ucwords(str_replace('_', ' ', $check)); ?>
                        </h3>
                        <p class="text-gray-600 mb-3"><?php echo htmlspecialchars($result['message']); ?></p>
                        
                        <?php if (is_array($result['value'])): ?>
                        <details class="bg-gray-50 p-3 rounded">
                            <summary class="cursor-pointer font-semibold text-sm text-gray-700">View Details</summary>
                            <pre class="mt-2 text-xs overflow-x-auto"><?php print_r($result['value']); ?></pre>
                        </details>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">Value: <?php echo htmlspecialchars($result['value']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Actions -->
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="<?php echo url('/'); ?>" class="bg-blue-500 hover:bg-blue-600 text-white text-center py-3 px-4 rounded-lg">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="<?php echo url('/auth/login'); ?>" class="bg-green-500 hover:bg-green-600 text-white text-center py-3 px-4 rounded-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                <a href="<?php echo url('/admin'); ?>" class="bg-purple-500 hover:bg-purple-600 text-white text-center py-3 px-4 rounded-lg">
                    <i class="fas fa-cog mr-2"></i>Admin
                </a>
                <button onclick="location.reload()" class="bg-gray-500 hover:bg-gray-600 text-white text-center py-3 px-4 rounded-lg">
                    <i class="fas fa-sync mr-2"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p>ForumHub Pro v<?php echo APP_VERSION; ?> | Environment: <?php echo ENVIRONMENT; ?></p>
            <p class="mt-1">Last checked: <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
    </div>
</body>
</html>
