<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Genre</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --dark-bg: #0a0a0a;
            --card-bg: rgba(255, 255, 255, 0.08);
            --card-hover: rgba(255, 255, 255, 0.12);
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
            --border-color: rgba(255, 255, 255, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-bg);
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 0 0 30px rgba(102, 126, 234, 0.3);
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            font-weight: 300;
        }

        .back-btn {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .back-btn:hover {
            background: var(--card-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            border-color: rgba(102, 126, 234, 0.5);
        }

        .genre-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            list-style: none;
            padding: 0;
        }

        .genre-item {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .genre-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .genre-item:hover::before {
            transform: scaleX(1);
        }

        .genre-item:hover {
            background: var(--card-hover);
            transform: translateY(-8px);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .genre-link {
            display: block;
            padding: 24px;
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1.1rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .genre-link:hover {
            color: var(--text-primary);
        }

        .genre-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .genre-name {
            margin-bottom: 8px;
        }

        .genre-arrow {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .genre-item:hover .genre-arrow {
            opacity: 1;
            transform: translateY(-50%) translateX(5px);
        }

        .stats-bar {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
        }

        .stats-item {
            text-align: center;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }
            
            .genre-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .container {
                padding: 0 15px;
            }
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(102, 126, 234, 0.03);
            animation: float 20s infinite ease-in-out;
        }

        .floating-circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 10%;
            animation-delay: -7s;
        }

        .floating-circle:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 20%;
            animation-delay: -14s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(30px) rotate(240deg); }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="container mt-4">
        <div class="page-header">
            <h1 class="page-title">Daftar Genre</h1>
            <p class="page-subtitle">Pilih genre favorit Anda untuk menemukan konten terbaik</p>
        </div>

        <a href="/" class="back-btn mb-4">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Home
        </a>

        <div class="stats-bar">
            <div class="row">
                <div class="col-4 stats-item">
                    <div class="stats-number" id="genreCount">0</div>
                    <div class="stats-label">Total Genre</div>
                </div>
                <div class="col-4 stats-item">
                    <div class="stats-number">∞</div>
                    <div class="stats-label">Konten Tersedia</div>
                </div>
                <div class="col-4 stats-item">
                    <div class="stats-number">24/7</div>
                    <div class="stats-label">Akses</div>
                </div>
            </div>
        </div>

        <ul class="genre-grid">
            <!-- Sample genres for demonstration -->
            <li class="genre-item">
                <a href="#" class="genre-link">
                    <div class="genre-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="genre-name">Romance</div>
                    <div class="genre-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="genre-item">
                <a href="#" class="genre-link">
                    <div class="genre-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="genre-name">Action</div>
                    <div class="genre-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="genre-item">
                <a href="#" class="genre-link">
                    <div class="genre-icon">
                        <i class="fas fa-laugh"></i>
                    </div>
                    <div class="genre-name">Comedy</div>
                    <div class="genre-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="genre-item">
                <a href="#" class="genre-link">
                    <div class="genre-icon">
                        <i class="fas fa-ghost"></i>
                    </div>
                    <div class="genre-name">Horror</div>
                    <div class="genre-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="genre-item">
                <a href="#" class="genre-link">
                    <div class="genre-icon">
                        <i class="fas fa-magic"></i>
                    </div>
                    <div class="genre-name">Fantasy</div>
                    <div class="genre-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="genre-item">
                <a href="#" class="genre-link">
                    <div class="genre-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="genre-name">Sci-Fi</div>
                    <div class="genre-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="genre-item">
                <a href="#" class="genre-link">
                    <div class="genre-icon">
                        <i class="fas fa-theater-masks"></i>
                    </div>
                    <div class="genre-name">Drama</div>
                    <div class="genre-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="genre-item">
                <a href="#" class="genre-link">
                    <div class="genre-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="genre-name">Mystery</div>
                    <div class="genre-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <script>
        // Animate genre count
        function animateCounter() {
            const counter = document.getElementById('genreCount');
            const target = document.querySelectorAll('.genre-item').length;
            let current = 0;
            const increment = target / 30;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.textContent = target;
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current);
                }
            }, 50);
        }

        // Add staggered animation to genre items
        function animateGenreItems() {
            const items = document.querySelectorAll('.genre-item');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    item.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }

        // Initialize animations when page loads
        window.addEventListener('load', () => {
            setTimeout(() => {
                animateCounter();
                animateGenreItems();
            }, 300);
        });

        // Add hover sound effect (optional)
        document.querySelectorAll('.genre-item').forEach(item => {
            item.addEventListener('mouseenter', () => {
                // You can add a subtle hover sound here if desired
                item.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>