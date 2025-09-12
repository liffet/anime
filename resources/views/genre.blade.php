<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Genre</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0f0f0f 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(120, 198, 255, 0.1) 0%, transparent 50%);
            z-index: -1;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 0 0 30px rgba(102, 126, 234, 0.3);
        }

        .page-subtitle {
            color: #b0b0b0;
            font-size: 1.2rem;
            font-weight: 300;
        }

        .back-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .back-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .back-button:hover::before {
            left: 100%;
        }

        .back-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .genre-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .list-group {
            background: transparent;
            border: none;
            gap: 15px;
        }

        .list-group-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 20px 25px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .list-group-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .list-group-item:hover::before {
            transform: scaleX(1);
        }

        .list-group-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(102, 126, 234, 0.5);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3),
                        0 0 30px rgba(102, 126, 234, 0.2);
        }

        .list-group-item a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
            position: relative;
        }

        .list-group-item a::after {
            content: '\f054';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .list-group-item:hover a::after {
            opacity: 1;
            transform: translateX(0);
        }

        .list-group-item a:hover {
            color: #667eea;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .container {
                padding: 0 15px;
            }
            
            .list-group-item {
                padding: 15px 20px;
            }
            
            .back-button {
                padding: 10px 20px;
                font-size: 14px;
            }
        }

        /* Loading animation */
        .list-group-item {
            animation: slideInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .list-group-item:nth-child(1) { animation-delay: 0.1s; }
        .list-group-item:nth-child(2) { animation-delay: 0.2s; }
        .list-group-item:nth-child(3) { animation-delay: 0.3s; }
        .list-group-item:nth-child(4) { animation-delay: 0.4s; }
        .list-group-item:nth-child(5) { animation-delay: 0.5s; }
        .list-group-item:nth-child(n+6) { animation-delay: 0.6s; }

        @keyframes slideInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Glowing effect on scroll */
        .genre-glow {
            position: fixed;
            pointer-events: none;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="genre-glow"></div>
    
    <div class="container mt-4">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-film me-3"></i>
                Daftar Genre
            </h1>
            <p class="page-subtitle">Pilih genre favorit Anda dan jelajahi koleksi terbaik</p>
        </div>
        
        <div class="text-center mb-4">
            <a href="/" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Home
            </a>
        </div>
        
        <div class="genre-container">
            <ul class="list-group">
                @foreach($genres as $genre)
                    <li class="list-group-item">
                        <a href="{{ route('genre.show', $genre['endpoint']) }}">
                            <span>
                                <i class="fas fa-play-circle me-3"></i>
                                {{ $genre['name'] }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        // Add interactive glow effect
        document.addEventListener('mousemove', (e) => {
            const glow = document.querySelector('.genre-glow');
            glow.style.left = e.clientX + 'px';
            glow.style.top = e.clientY + 'px';
        });

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>