<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $genreName }} Anime</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #0a0a0a 0%, #1a0a1a 25%, #0a1a1a 50%, #1a1a0a 75%, #0a0a0a 100%);
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    /* Animated background */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 25% 25%, rgba(255, 0, 150, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(0, 255, 150, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 50% 50%, rgba(150, 0, 255, 0.1) 0%, transparent 50%);
      animation: backgroundPulse 15s ease-in-out infinite;
      z-index: -1;
    }

    @keyframes backgroundPulse {
      0%, 100% { opacity: 0.3; transform: scale(1) rotate(0deg); }
      33% { opacity: 0.6; transform: scale(1.1) rotate(120deg); }
      66% { opacity: 0.4; transform: scale(0.9) rotate(240deg); }
    }

    /* Header Styling */
    .genre-header {
      text-align: center;
      padding: 3rem 0 2rem;
      position: relative;
    }

    .genre-title {
      font-size: 3.5rem;
      font-weight: 800;
      background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #f9ca24);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-shadow: 0 0 40px rgba(255, 107, 107, 0.3);
      margin-bottom: 1rem;
      position: relative;
    }

    .genre-title::before {
      content: '//';
      position: absolute;
      left: -60px;
      color: #666;
      font-weight: normal;
    }

    .genre-subtitle {
      color: #aaa;
      font-size: 1.2rem;
      font-weight: 300;
    }

    /* Pagination Styling */
    .pagination-container {
      display: flex;
      justify-content: center;
      margin: 2rem 0;
    }

    .pagination {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 50px;
      padding: 8px;
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .page-item {
      margin: 0 5px;
    }

    .page-link {
      background: transparent;
      border: none;
      color: #aaa;
      padding: 12px 20px;
      border-radius: 30px;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      font-weight: 600;
      position: relative;
      overflow: hidden;
    }

    .page-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transition: left 0.5s;
    }

    .page-link:hover::before {
      left: 100%;
    }

    .page-link:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .page-item.active .page-link {
      background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
      color: #fff;
      box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
    }

    /* Anime Cards */
    .anime-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 2rem;
      padding: 2rem 0;
    }

    .anime-card {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 20px;
      overflow: hidden;
      position: relative;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      cursor: pointer;
    }

    .anime-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #f9ca24);
      transform: scaleX(0);
      transition: transform 0.3s ease;
      z-index: 2;
    }

    .anime-card:hover::before {
      transform: scaleX(1);
    }

    .anime-card:hover {
      transform: translateY(-10px) scale(1.02);
      background: rgba(255, 255, 255, 0.1);
      box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.4),
        0 0 50px rgba(255, 107, 107, 0.2);
      border-color: rgba(255, 107, 107, 0.3);
    }

    .anime-image-container {
      position: relative;
      overflow: hidden;
    }

    .anime-card img {
      width: 100%;
      height: 320px;
      object-fit: cover;
      transition: all 0.4s ease;
      filter: brightness(0.8);
    }

    .anime-card:hover img {
      transform: scale(1.1);
      filter: brightness(1) saturate(1.2);
    }

    .badge-episode {
      position: absolute;
      top: 15px;
      right: 15px;
      background: linear-gradient(45deg, rgba(0, 0, 0, 0.8), rgba(255, 107, 107, 0.8));
      color: #fff;
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      z-index: 3;
    }

    .play-overlay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(0);
      background: rgba(255, 107, 107, 0.9);
      border-radius: 50%;
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: #fff;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      z-index: 3;
      backdrop-filter: blur(10px);
    }

    .anime-card:hover .play-overlay {
      transform: translate(-50%, -50%) scale(1);
    }

    .anime-info {
      padding: 20px;
      position: relative;
    }

    .anime-title {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 10px;
      color: #fff;
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .anime-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .new-episode-badge {
      background: linear-gradient(45deg, #4ecdc4, #45b7d1);
      color: #fff;
      padding: 4px 12px;
      border-radius: 15px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .btn-watch {
      background: transparent;
      border: 2px solid rgba(255, 255, 255, 0.2);
      color: #aaa;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      transition: all 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn-watch:hover {
      background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
      border-color: transparent;
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .genre-title {
        font-size: 2.5rem;
      }
      
      .anime-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
      }
      
      .anime-card img {
        height: 280px;
      }
      
      .genre-title::before {
        left: -40px;
      }
    }

    @media (max-width: 576px) {
      .anime-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.8rem;
      }
      
      .anime-info {
        padding: 15px;
      }
      
      .anime-title {
        font-size: 1rem;
      }
    }

    /* Loading animations */
    .anime-card {
      animation: fadeInUp 0.8s ease forwards;
      opacity: 0;
      transform: translateY(30px);
    }

    .anime-card:nth-child(1) { animation-delay: 0.1s; }
    .anime-card:nth-child(2) { animation-delay: 0.2s; }
    .anime-card:nth-child(3) { animation-delay: 0.3s; }
    .anime-card:nth-child(4) { animation-delay: 0.4s; }
    .anime-card:nth-child(5) { animation-delay: 0.5s; }
    .anime-card:nth-child(6) { animation-delay: 0.6s; }
    .anime-card:nth-child(7) { animation-delay: 0.7s; }
    .anime-card:nth-child(8) { animation-delay: 0.8s; }
    .anime-card:nth-child(n+9) { animation-delay: 0.9s; }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Scrollbar styling */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.05);
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(45deg, #ff5252, #26c6da);
    }
  </style>
</head>
<body>
  <!-- Header Section -->
  <div class="genre-header">
    <h1 class="genre-title">{{ $genreName }}</h1>
    <p class="genre-subtitle">Discover amazing anime in this genre</p>
  </div>

  <div class="text-center mb-4">
            <a href="/" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Home
            </a>
        </div>
        
  <!-- Pagination Top -->
  <div class="pagination-container">
    <nav>
      <ul class="pagination">
        {{-- Tombol Previous --}}
        @if ($currentPage > 1)
          <li class="page-item">
            <a class="page-link" href="{{ url('/genre/'.$genreName.'?page='.($currentPage - 1)) }}">
              <i class="fas fa-chevron-left me-2"></i> Prev
            </a>
          </li>
        @endif

        {{-- Halaman Aktif --}}
        <li class="page-item active">
          <span class="page-link">
            <i class="fas fa-bookmark me-2"></i>{{ $currentPage }}
          </span>
        </li>

        {{-- Tombol Next --}}
        @if ($hasNextPage)
          <li class="page-item">
            <a class="page-link" href="{{ url('/genre/'.$genreName.'?page='.($currentPage + 1)) }}">
              Next <i class="fas fa-chevron-right ms-2"></i>
            </a>
          </li>
        @endif
      </ul>
    </nav>
  </div>

  <!-- Anime Grid -->
  <div class="container py-4">
    <div class="anime-grid">
      @foreach ($animeList as $anime)
        <div class="anime-card h-100">
          <div class="anime-image-container">
            <img src="{{ $anime['thumb'] }}" alt="{{ $anime['title'] }}" loading="lazy">
            <div class="badge-episode">
              <i class="fas fa-play-circle me-1"></i>
              EP {{ $anime['total_episode'] }}
            </div>
            <div class="play-overlay">
              <i class="fas fa-play"></i>
            </div>
          </div>
          <div class="anime-info">
            <h5 class="anime-title">{{ $anime['title'] }}</h5>
            <div class="anime-footer">
              <span class="new-episode-badge">
                <i class="fas fa-star me-1"></i>
                New Episode
              </span>
              <a href="{{ url('/anime/'.$anime['endpoint']) }}" class="btn-watch">
                <i class="fas fa-play"></i>
                Watch
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Pagination Bottom -->
  <div class="pagination-container">
    <nav>
      <ul class="pagination">
        {{-- Tombol Previous --}}
        @if ($currentPage > 1)
          <li class="page-item">
            <a class="page-link" href="{{ url('/genre/'.$genreName.'?page='.($currentPage - 1)) }}">
              <i class="fas fa-chevron-left me-2"></i> Prev
            </a>
          </li>
        @endif

        {{-- Halaman Aktif --}}
        <li class="page-item active">
          <span class="page-link">
            <i class="fas fa-bookmark me-2"></i>{{ $currentPage }}
          </span>
        </li>

        {{-- Tombol Next --}}
        @if ($hasNextPage)
          <li class="page-item">
            <a class="page-link" href="{{ url('/genre/'.$genreName.'?page='.($currentPage + 1)) }}">
              Next <i class="fas fa-chevron-right ms-2"></i>
            </a>
          </li>
        @endif
      </ul>
    </nav>
  </div>

  <script>
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.classList.add('loaded');
            observer.unobserve(img);
          }
        });
      });

      document.querySelectorAll('img[loading="lazy"]').forEach(img => {
        imageObserver.observe(img);
      });
    }
  </script>
</body>
</html>