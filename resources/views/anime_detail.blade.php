<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $animeDetail['title'] }} | AnimeHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Orbitron:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cyber: {
                            dark: '#0a0a0f',
                            base: '#151520',
                            light: '#1f1f2e',
                            accent: '#2a2a3e',
                            text: '#e6e6f0',
                            highlight: '#8b5cf6'
                        },
                        neon: {
                            purple: '#a855f7',
                            pink: '#ec4899',
                            cyan: '#06b6d4',
                            green: '#10b981',
                            yellow: '#f59e0b',
                            red: '#ef4444'
                        }
                    },
                    fontFamily: {
                        sans: ['"Inter"', 'system-ui', 'sans-serif'],
                        display: ['"Orbitron"', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'glow-pulse': 'glowPulse 2s ease-in-out infinite alternate',
                        'matrix-rain': 'matrixRain 15s linear infinite',
                        'neon-flicker': 'neonFlicker 2s ease-in-out infinite alternate',
                        'bounce-subtle': 'bounceSubtle 2s ease-in-out infinite',
                        'rotate-slow': 'rotateSlow 20s linear infinite',
                        'pulse-glow': 'pulseGlow 1.5s ease-in-out infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(50px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(180deg)' }
                        },
                        glowPulse: {
                            '0%': { boxShadow: '0 0 20px rgba(139, 92, 246, 0.4)' },
                            '100%': { boxShadow: '0 0 40px rgba(139, 92, 246, 0.8)' }
                        },
                        matrixRain: {
                            '0%': { transform: 'translateY(-100vh) rotate(0deg)' },
                            '100%': { transform: 'translateY(100vh) rotate(360deg)' }
                        },
                        neonFlicker: {
                            '0%': { textShadow: '0 0 10px currentColor, 0 0 20px currentColor' },
                            '100%': { textShadow: '0 0 15px currentColor, 0 0 30px currentColor, 0 0 45px currentColor' }
                        },
                        bounceSubtle: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        rotateSlow: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' }
                        },
                        pulseGlow: {
                            '0%, 100%': { transform: 'scale(1)', opacity: '1' },
                            '50%': { transform: 'scale(1.05)', opacity: '0.8' }
                        }
                    },
                    backdropBlur: {
                        xs: '2px'
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .text-gradient {
                @apply bg-clip-text text-transparent bg-gradient-to-r from-neon-purple via-neon-pink to-neon-cyan;
            }
            .text-gradient-alt {
                @apply bg-clip-text text-transparent bg-gradient-to-r from-neon-cyan via-neon-green to-neon-yellow;
            }
            .glass-effect {
                @apply bg-white/5 backdrop-blur-xl border border-white/10;
            }
            .neon-border {
                @apply border border-neon-purple/50 shadow-lg shadow-neon-purple/25;
            }
            .episode-highlight {
                @apply relative overflow-hidden;
            }
            .episode-highlight::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(139, 92, 246, 0.2), transparent);
                transition: left 0.5s;
            }
            .episode-highlight:hover::before {
                left: 100%;
            }
            .matrix-bg {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: -1;
                overflow: hidden;
            }
            .matrix-char {
                position: absolute;
                color: rgba(139, 92, 246, 0.1);
                font-family: 'Courier New', monospace;
                animation: matrixRain linear infinite;
                user-select: none;
            }
            .floating-particles {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: -1;
            }
            .particle {
                position: absolute;
                background: radial-gradient(circle, rgba(139, 92, 246, 0.3), transparent);
                border-radius: 50%;
                animation: float 10s ease-in-out infinite;
            }
        }
    </style>
</head>
<body class="bg-cyber-dark text-cyber-text font-sans overflow-x-hidden">
    <!-- Matrix Background -->
    <div class="matrix-bg" id="matrixBg"></div>
    
    <!-- Floating Particles -->
    <div class="floating-particles" id="particles"></div>

    <!-- Navigation -->
    <nav class="glass-effect sticky top-0 z-50 border-b border-neon-purple/20 shadow-2xl">
        <div class="max-w-8xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Back Button -->
                <a href="javascript:history.back()" class="flex items-center glass-effect px-6 py-3 rounded-full text-cyber-text hover:text-white transition-all duration-500 transform hover:scale-110 neon-border group">
                    <i class="fas fa-arrow-left mr-3 group-hover:animate-bounce-subtle"></i>
                    <span class="font-semibold">Back to Browse</span>
                </a>
                
                <!-- Page Title -->
                <h1 class="text-2xl font-display font-bold truncate max-w-xs md:max-w-md lg:max-w-3xl text-gradient animate-neon-flicker">
                    {{ $animeDetail['title'] }}
                </h1>
                
                <!-- Home Button -->
                <a href="/" class="glass-effect px-6 py-3 rounded-full text-cyber-text hover:text-white transition-all duration-500 transform hover:scale-110 neon-border">
                    <i class="fas fa-home text-xl"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-8xl mx-auto px-6 py-12 animate-fade-in">
        <!-- Anime Header -->
        <div class="flex flex-col xl:flex-row gap-12 mb-16">
            <!-- Anime Poster -->
            <div class="w-full xl:w-1/3 2xl:w-1/4">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-neon-purple via-neon-pink to-neon-cyan rounded-3xl opacity-20 group-hover:opacity-40 transition-opacity duration-700 animate-rotate-slow"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-cyber-dark/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 rounded-2xl"></div>
                    <div class="absolute bottom-6 left-6 right-6 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700">
                        <div class="glass-effect rounded-xl p-4 neon-border">
                            <p class="text-sm font-semibold text-neon-cyan">
                                <i class="fas fa-star mr-2"></i>Premium Quality
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Anime Details -->
            <div class="w-full xl:w-2/3 2xl:w-3/4">
                <div class="glass-effect rounded-3xl p-8 shadow-2xl neon-border relative overflow-hidden h-full">
                    <!-- Background Pattern -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-neon-purple/10 to-transparent rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-neon-cyan/10 to-transparent rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <h2 class="text-4xl font-display font-black mb-6 text-gradient animate-neon-flicker leading-tight">
                            {{ $animeDetail['title'] }}
                        </h2>
                        
                        <!-- Synopsis -->
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold mb-4 text-gradient-alt flex items-center">
                                <i class="fas fa-book-open mr-3 animate-bounce-subtle"></i>
                                Synopsis
                            </h3>
                            <div class="glass-effect rounded-2xl p-6 neon-border">
                                <p class="text-cyber-text leading-relaxed text-lg">{{ $animeDetail['synopsis'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="glass-effect p-6 rounded-2xl neon-border group hover:scale-105 transition-transform duration-500">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-info-circle text-2xl text-neon-green mr-3 animate-pulse-glow"></i>
                                    <p class="text-sm text-cyber-text/70 font-semibold uppercase tracking-wider">Status</p>
                                </div>
                                <p class="font-bold text-xl text-gradient-alt">{{ $animeDetail['status'] ?? 'Unknown' }}</p>
                            </div>
                            <div class="glass-effect p-6 rounded-2xl neon-border group hover:scale-105 transition-transform duration-500">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-film text-2xl text-neon-cyan mr-3 animate-pulse-glow"></i>
                                    <p class="text-sm text-cyber-text/70 font-semibold uppercase tracking-wider">Total Episode</p>
                                </div>
                                <p class="font-bold text-xl text-gradient">{{ count($animeDetail['episodes']) }} Episodes</p>
                            </div>
                            <div class="glass-effect p-6 rounded-2xl neon-border group hover:scale-105 transition-transform duration-500">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-star text-2xl text-neon-yellow mr-3 animate-pulse-glow"></i>
                                    <p class="text-sm text-cyber-text/70 font-semibold uppercase tracking-wider">Rating</p>
                                </div>
                                <p class="font-bold text-xl text-gradient-alt">{{ $animeDetail['rating'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4">
                            <button class="bg-gradient-to-r from-neon-purple to-neon-pink hover:from-neon-pink hover:to-neon-cyan text-white px-8 py-4 rounded-full font-bold transition-all duration-500 transform hover:scale-110 shadow-lg hover:shadow-neon-purple/50 flex items-center group">
                                <i class="fas fa-bookmark mr-3 group-hover:animate-bounce-subtle"></i> 
                                Add to Watchlist
                            </button>
                            <button class="glass-effect text-cyber-text hover:text-white px-8 py-4 rounded-full font-bold transition-all duration-500 transform hover:scale-110 neon-border hover:bg-white/10 flex items-center group">
                                <i class="fas fa-share-alt mr-3 group-hover:animate-bounce-subtle"></i> 
                                Share Anime
                            </button>
                            <button class="glass-effect text-cyber-text hover:text-white px-8 py-4 rounded-full font-bold transition-all duration-500 transform hover:scale-110 neon-border hover:bg-white/10 flex items-center group">
                                <i class="fas fa-heart mr-3 group-hover:animate-bounce-subtle text-neon-red"></i> 
                                Add to Favorites
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Episode List -->
        <section class="mb-16">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-4xl font-display font-black text-gradient flex items-center">
                    <div class="relative mr-4">
                        <i class="fas fa-list-ul text-3xl animate-float"></i>
                        <div class="absolute inset-0 animate-ping">
                            <i class="fas fa-list-ul text-3xl opacity-20"></i>
                        </div>
                    </div>
                    Episode Collection
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="glass-effect px-6 py-3 text-neon-cyan font-bold rounded-full neon-border">
                        <i class="fas fa-play-circle mr-2"></i>
                        {{ count($animeDetail['episodes']) }} Episodes Available
                    </span>
                    <button class="glass-effect px-6 py-3 rounded-full text-cyber-text hover:text-white transition-all duration-300 neon-border hover:bg-white/10">
                        <i class="fas fa-sort mr-2"></i>Sort
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($animeDetail['episodes'] as $index => $episode)
                <a 
                    href="{{ url('/anime/' . $animeDetail['endpoint'] . '/episode/' . basename($episode['url']) . '/watch') }}" 
                    class="glass-effect hover:bg-white/10 rounded-2xl p-6 shadow-lg transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 group episode-highlight neon-border animate-slide-up"
                    style="animation-delay: {{ $index * 0.05 }}s;"
                >
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-neon-purple to-neon-pink rounded-full flex items-center justify-center font-bold text-white text-lg animate-pulse-glow">
                                {{ $loop->iteration }}
                            </div>
                            <div>
                                <h3 class="font-bold text-cyber-text group-hover:text-white transition-colors duration-300 text-lg">
                                    Episode {{ $loop->iteration }}
                                </h3>
                                <p class="text-sm text-cyber-text/70 group-hover:text-cyber-text/90 transition-colors duration-300">
                                    {{ $episode['title'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="glass-effect px-3 py-1 text-xs font-semibold rounded-full text-neon-green border border-neon-green/30">
                                <i class="fas fa-circle mr-1 animate-pulse"></i>Available
                            </span>
                            <span class="text-xs text-cyber-text/50">HD Quality</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-play-circle text-2xl text-cyber-text/50 group-hover:text-neon-purple group-hover:animate-bounce-subtle transition-all duration-300"></i>
                        </div>
                    </div>
                    
                    <!-- Hover Effect Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-neon-purple/10 to-neon-pink/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"></div>
                </a>
                @endforeach
            </div>
        </section>

    
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Matrix background effect
            function createMatrix() {
                const matrixBg = document.getElementById('matrixBg');
                const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ♦♥♠♣αβγδεζηθικλμνξοπρστυφχψω';
                
                for (let i = 0; i < 30; i++) {
                    const char = document.createElement('div');
                    char.className = 'matrix-char';
                    char.textContent = chars[Math.floor(Math.random() * chars.length)];
                    char.style.left = Math.random() * 100 + '%';
                    char.style.animationDuration = (Math.random() * 15 + 10) + 's';
                    char.style.animationDelay = Math.random() * 5 + 's';
                    char.style.fontSize = Math.random() * 8 + 10 + 'px';
                    matrixBg.appendChild(char);
                }
            }
            createMatrix();

            // Floating particles effect
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                
                for (let i = 0; i < 15; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';
                    particle.style.width = Math.random() * 6 + 2 + 'px';
                    particle.style.height = particle.style.width;
                    particle.style.animationDuration = Math.random() * 10 + 5 + 's';
                    particle.style.animationDelay = Math.random() * 5 + 's';
                    particlesContainer.appendChild(particle);
                }
            }
            createParticles();

            // Enhanced hover effects for episode cards
            document.querySelectorAll('.episode-highlight').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.05)';
                    this.style.boxShadow = '0 25px 50px rgba(139, 92, 246, 0.3)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '';
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Enhanced page load animations
            const animatedElements = document.querySelectorAll('.animate-fade-in, .animate-slide-up');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            animatedElements.forEach(el => {
                observer.observe(el);
            });

            // Dynamic gradient background animation
            let gradientAngle = 0;
            const body = document.body;
            
            setInterval(() => {
                gradientAngle += 0.5;
                body.style.background = `linear-gradient(${gradientAngle}deg, #0a0a0f, #151520, #1f1f2e)`;
            }, 100);

            // Add click effect to buttons
            document.querySelectorAll('button, a').forEach(element => {
                element.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(139, 92, 246, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>