<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForumHub Pro - The Future of Online Communities</title>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Three.js -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js"></script>
    
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            background: #0a0a0a;
            color: white;
        }
        
        #canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 0;
        }
        
        .content-layer {
            position: relative;
            z-index: 10;
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
        }
        
        .btn-glow {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
            transition: all 0.3s ease;
        }
        
        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.8);
            transform: scale(1.05);
        }
        
        .feature-card {
            opacity: 0;
            transform: translateY(50px);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes pulse-ring {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 30px rgba(102, 126, 234, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }
        
        .pulse {
            animation: pulse-ring 2s infinite;
        }
        
        @keyframes bounce-gentle {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .bounce-arrow {
            animation: bounce-gentle 2s ease-in-out infinite;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-black/30 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-2">
                <i class="fas fa-comments text-3xl gradient-text"></i>
                <span class="text-xl font-bold">ForumHub Pro</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="<?php echo url('/auth/login'); ?>" 
                   class="px-6 py-2 text-white hover:text-blue-400 transition-colors">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="<?php echo url('/auth/register'); ?>" 
                   class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full font-bold hover:from-blue-700 hover:to-purple-700 transition-all">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- 3D Canvas Container -->
<div id="canvas-container"></div>

<!-- Content Layer -->
<div class="content-layer">
    
    <!-- Hero Section -->
    <section class="hero-section px-4">
        <div class="max-w-5xl mx-auto">
            <div class="floating mb-8">
                <i class="fas fa-comments text-8xl md:text-9xl gradient-text"></i>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-6 opacity-0" id="hero-title">
                ForumHub <span class="gradient-text">Pro</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-400 mb-12 opacity-0" id="hero-subtitle">
                Connect. Discuss. Grow. <br>
                <span class="gradient-text">The Future of Online Communities.</span>
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center opacity-0" id="hero-cta">
                <a href="<?php echo url('/auth/register'); ?>" 
                   class="btn-glow px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full font-bold text-lg hover:from-blue-700 hover:to-purple-700 transition-all">
                    <i class="fas fa-rocket mr-2"></i> Join Now
                </a>
                <a href="<?php echo url('/threads'); ?>" 
                   class="px-8 py-4 border-2 border-white/30 rounded-full font-bold text-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-compass mr-2"></i> Explore Community
                </a>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="mt-20 opacity-0" id="scroll-indicator">
                <a href="#features" class="inline-block cursor-pointer bounce-arrow" onclick="smoothScrollToFeatures(event)">
                    <div class="pulse inline-block p-4 rounded-full border-2 border-white/30 hover:border-white/50 hover:bg-white/5 transition-all">
                        <i class="fas fa-chevron-down text-2xl"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section id="features" class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-16">
                <span class="gradient-text">Powerful Features</span>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card feature-card text-center">
                    <div class="text-5xl mb-4">
                        <i class="fas fa-comments gradient-text"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Create Threads</h3>
                    <p class="text-gray-400">
                        Start discussions effortlessly with rich text, polls, and file attachments
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="glass-card feature-card text-center">
                    <div class="text-5xl mb-4">
                        <i class="fas fa-thumbs-up gradient-text"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Vote & Engage</h3>
                    <p class="text-gray-400">
                        Like, share, and build your reputation in the community
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="glass-card feature-card text-center">
                    <div class="text-5xl mb-4">
                        <i class="fas fa-chart-line gradient-text"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Analytics</h3>
                    <p class="text-gray-400">
                        Track community growth and engagement with beautiful charts
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="glass-card feature-card text-center">
                    <div class="text-5xl mb-4">
                        <i class="fas fa-message gradient-text"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Private Chat</h3>
                    <p class="text-gray-400">
                        Connect one-on-one with real-time messaging
                    </p>
                </div>
                
                <!-- Feature 5 -->
                <div class="glass-card feature-card text-center">
                    <div class="text-5xl mb-4">
                        <i class="fas fa-calendar gradient-text"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Events</h3>
                    <p class="text-gray-400">
                        Create and attend community events with integrated discussions
                    </p>
                </div>
                
                <!-- Feature 6 -->
                <div class="glass-card feature-card text-center">
                    <div class="text-5xl mb-4">
                        <i class="fas fa-shield-halved gradient-text"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Moderation</h3>
                    <p class="text-gray-400">
                        Powerful tools to keep your community safe and healthy
                    </p>
                </div>
                
                <!-- Feature 7 -->
                <div class="glass-card feature-card text-center">
                    <div class="text-5xl mb-4">
                        <i class="fas fa-search gradient-text"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Advanced Search</h3>
                    <p class="text-gray-400">
                        Find exactly what you need with filters and instant results
                    </p>
                </div>
                
                <!-- Feature 8 -->
                <div class="glass-card feature-card text-center">
                    <div class="text-5xl mb-4">
                        <i class="fas fa-moon gradient-text"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Dark Mode</h3>
                    <p class="text-gray-400">
                        Beautiful themes that adapt to your preference
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="py-20 px-4 bg-gradient-to-r from-blue-900/20 to-purple-900/20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold gradient-text mb-2">10K+</div>
                    <div class="text-gray-400">Active Users</div>
                </div>
                <div>
                    <div class="text-5xl font-bold gradient-text mb-2">50K+</div>
                    <div class="text-gray-400">Discussions</div>
                </div>
                <div>
                    <div class="text-5xl font-bold gradient-text mb-2">200K+</div>
                    <div class="text-gray-400">Messages</div>
                </div>
                <div>
                    <div class="text-5xl font-bold gradient-text mb-2">24/7</div>
                    <div class="text-gray-400">Online Support</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Ready to <span class="gradient-text">Join</span> the Future?
            </h2>
            <p class="text-xl text-gray-400 mb-12">
                Be part of the most innovative community platform. Start your journey today.
            </p>
            <a href="<?php echo url('/auth/register'); ?>" 
               class="btn-glow inline-block px-12 py-5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full font-bold text-xl hover:from-blue-700 hover:to-purple-700 transition-all">
                <i class="fas fa-rocket mr-2"></i> Get Started Free
            </a>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="py-12 px-4 border-t border-white/10">
        <div class="max-w-7xl mx-auto text-center text-gray-400">
            <p>&copy; 2025 ForumHub Pro. The Future of Online Communities.</p>
        </div>
    </footer>
    
</div>

<script>
// Three.js Scene Setup
let scene, camera, renderer, particles, mouse, raycaster;

function init3DScene() {
    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    document.getElementById('canvas-container').appendChild(renderer.domElement);
    
    // Create particle system
    const geometry = new THREE.BufferGeometry();
    const particleCount = 1500;
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);
    
    for (let i = 0; i < particleCount * 3; i += 3) {
        positions[i] = (Math.random() - 0.5) * 100;
        positions[i + 1] = (Math.random() - 0.5) * 100;
        positions[i + 2] = (Math.random() - 0.5) * 100;
        
        colors[i] = 0.4 + Math.random() * 0.4;
        colors[i + 1] = 0.5 + Math.random() * 0.5;
        colors[i + 2] = 0.9 + Math.random() * 0.1;
    }
    
    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
    
    const material = new THREE.PointsMaterial({
        size: 0.5,
        vertexColors: true,
        transparent: true,
        opacity: 0.8,
        blending: THREE.AdditiveBlending
    });
    
    particles = new THREE.Points(geometry, material);
    scene.add(particles);
    
    // Add some glowing spheres
    for (let i = 0; i < 20; i++) {
        const sphereGeometry = new THREE.SphereGeometry(0.5, 16, 16);
        const sphereMaterial = new THREE.MeshBasicMaterial({
            color: new THREE.Color(0.4 + Math.random() * 0.3, 0.5 + Math.random() * 0.3, 0.9),
            transparent: true,
            opacity: 0.6
        });
        const sphere = new THREE.Mesh(sphereGeometry, sphereMaterial);
        
        sphere.position.set(
            (Math.random() - 0.5) * 50,
            (Math.random() - 0.5) * 50,
            (Math.random() - 0.5) * 50
        );
        
        scene.add(sphere);
    }
    
    camera.position.z = 50;
    
    // Mouse tracking
    mouse = { x: 0, y: 0 };
    document.addEventListener('mousemove', (event) => {
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    });
    
    animate();
}

function animate() {
    requestAnimationFrame(animate);
    
    // Rotate particles
    particles.rotation.y += 0.001;
    particles.rotation.x += 0.0005;
    
    // Camera follows mouse
    camera.position.x += (mouse.x * 10 - camera.position.x) * 0.05;
    camera.position.y += (mouse.y * 10 - camera.position.y) * 0.05;
    camera.lookAt(scene.position);
    
    renderer.render(scene, camera);
}

// GSAP Animations
function initAnimations() {
    gsap.registerPlugin(ScrollTrigger);
    
    // Hero animations
    gsap.to('#hero-title', {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 0.5
    });
    
    gsap.to('#hero-subtitle', {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 0.8
    });
    
    gsap.to('#hero-cta', {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 1.1
    });
    
    gsap.to('#scroll-indicator', {
        opacity: 1,
        duration: 1,
        delay: 1.5
    });
    
    // Feature cards animation
    gsap.utils.toArray('.feature-card').forEach((card, index) => {
        gsap.to(card, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            delay: index * 0.1,
            scrollTrigger: {
                trigger: card,
                start: 'top 80%'
            }
        });
    });
}

// Window resize handler
window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});

// Initialize
init3DScene();
initAnimations();

// Smooth scroll function for the arrow button
function smoothScrollToFeatures(event) {
    event.preventDefault();
    const featuresSection = document.getElementById('features');
    if (featuresSection) {
        featuresSection.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}

console.log('ForumHub Pro - 3D Landing Page Loaded');
</script>

</body>
</html>
