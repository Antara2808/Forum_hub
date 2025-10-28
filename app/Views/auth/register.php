<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - ForumHub Pro</title>
    
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
<body class="flex items-center justify-center min-h-screen p-4 py-12">
    
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
        
        <!-- Register Card -->
        <div class="glass-card p-8">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">Create Account</h2>
            
            <?php if ($error = flash('error')): ?>
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-200">
                <i class="fas fa-exclamation-circle mr-2"></i><?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo url('/auth/register'); ?>" class="space-y-6">
                <?php echo csrfField(); ?>
                
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-user-tag mr-2"></i>Join As
                    </label>
                    <select name="role" required class="form-input">
                        <option value="user">Regular User - Participate in discussions</option>
                        <option value="moderator">Moderator - Help manage the community</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Choose how you want to contribute</p>
                </div>
                
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-user mr-2"></i>Username
                    </label>
                    <input type="text" name="username" required 
                           class="form-input" 
                           placeholder="Choose a username"
                           minlength="3" maxlength="50">
                </div>
                
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
                               placeholder="••••••••"
                               minlength="6">
                        <i class="fas fa-eye password-toggle" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Minimum 6 characters</p>
                </div>
                
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-lock mr-2"></i>Confirm Password
                    </label>
                    <div class="password-container">
                        <input type="password" id="password_confirm" name="password_confirm" required 
                               class="form-input" 
                               style="padding-right: 45px;"
                               placeholder="••••••••">
                        <i class="fas fa-eye password-toggle" id="togglePasswordConfirm" onclick="togglePasswordConfirmVisibility()"></i>
                    </div>
                </div>
                
                <div>
                    <label class="flex items-start text-gray-300 text-sm">
                        <input type="checkbox" name="terms" required class="mr-2 mt-1 rounded">
                        <span>I agree to the <a href="#" class="text-blue-400 hover:text-blue-300">Terms of Service</a> and <a href="#" class="text-blue-400 hover:text-blue-300">Privacy Policy</a></span>
                    </label>
                </div>
                
                <button type="submit" class="btn-primary w-full">
                    <i class="fas fa-user-plus mr-2"></i>Create Account
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    Already have an account? 
                    <a href="<?php echo url('/auth/login'); ?>" class="text-blue-400 hover:text-blue-300 font-semibold">Sign In</a>
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
        
        function togglePasswordConfirmVisibility() {
            const passwordInput = document.getElementById('password_confirm');
            const toggleIcon = document.getElementById('togglePasswordConfirm');
            
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
