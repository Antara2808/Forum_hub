<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ForumHub Pro</title>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0F1419 0%, #15202B 100%);
            min-height: 100vh;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #1D9BF0 0%, #667eea 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-card {
            background: rgba(21, 32, 43, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid #38444D;
            border-radius: 20px;
        }
        
        .form-input {
            background: #192734;
            border: 1px solid #38444D;
            color: #E7E9EA;
            padding: 12px 16px;
            border-radius: 10px;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #1D9BF0;
            background: #1C2938;
        }
        
        .form-input::placeholder {
            color: rgba(231, 233, 234, 0.5);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1D9BF0 0%, #667eea 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(29, 155, 240, 0.4);
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8899A6;
            transition: color 0.2s;
        }
        
        .password-toggle:hover {
            color: #1D9BF0;
        }
        
        .password-container {
            position: relative;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    
    <!-- Background Pattern -->
    <div class="fixed inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 32px 32px;"></div>
    </div>
    
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="<?php echo url('/'); ?>" class="inline-block">
                <i class="fas fa-comments text-6xl gradient-text mb-4"></i>
                <h1 class="text-3xl font-bold text-white">ForumHub <span class="gradient-text">Pro</span></h1>
            </a>
        </div>
        
        <!-- Login Card -->
        <div class="glass-card p-8">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">Welcome Back</h2>
            
            <?php if ($error = flash('error')): ?>
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-200">
                <i class="fas fa-exclamation-circle mr-2"></i><?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success = flash('success')): ?>
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-200">
                <i class="fas fa-check-circle mr-2"></i><?php echo $success; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo url('/auth/login'); ?>" class="space-y-6">
                <?php echo csrfField(); ?>
                
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>
                    <input type="email" name="email" required 
                           class="form-input" 
                           placeholder="your@email.com">
                </div>
                
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required 
                               class="form-input" 
                               style="padding-right: 45px;"
                               placeholder="••••••••">
                        <i class="fas fa-eye password-toggle" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-gray-300">
                        <input type="checkbox" name="remember" class="mr-2 rounded">
                        <span class="text-sm">Remember me</span>
                    </label>
                </div>
                
                <button type="submit" class="btn-primary w-full">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    Don't have an account? 
                    <a href="<?php echo url('/auth/register'); ?>" class="text-blue-400 hover:text-blue-300 font-semibold">Sign Up</a>
                </p>
            </div>
        </div>
        
        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="<?php echo url('/'); ?>" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
        </div>
    </div>
    
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
