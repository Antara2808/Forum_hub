<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Update - ForumHub Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0F1419 0%, #15202B 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="max-w-md w-full mx-4 bg-[#15202B] border border-[#38444D] rounded-lg p-8 text-center">
        <div class="text-6xl mb-4">🔄</div>
        <h1 class="text-2xl font-bold text-white mb-4">Session Update Required</h1>
        <p class="text-gray-400 mb-6">
            To fix the reputation display issue, please logout and login again.
        </p>
        
        <div class="space-y-3">
            <a href="<?php echo BASE_URL; ?>/auth/logout" 
               class="block w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all">
                Logout & Login Again
            </a>
            
            <a href="<?php echo BASE_URL; ?>/home" 
               class="block w-full px-6 py-3 bg-gray-700 text-white rounded-lg font-semibold hover:bg-gray-600 transition-all">
                Continue (May Show Warnings)
            </a>
        </div>
        
        <div class="mt-6 p-4 bg-blue-900/20 border border-blue-800/30 rounded-lg text-left">
            <p class="text-sm text-blue-300">
                <strong>Why?</strong> Your session was created before the reputation system was added. 
                Logging out and back in will update your session with the new data.
            </p>
        </div>
    </div>
</body>
</html>
