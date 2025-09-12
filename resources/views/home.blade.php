<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AnimeHub | Premium Anime Collection</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            premium: {
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
              green: '#10b981'
            }
          },
          fontFamily: {
            sans: ['"Inter"', 'system-ui', 'sans-serif'],
            display: ['"Orbitron"', 'sans-serif']
          },
          animation: {
            'fade-in': 'fadeIn 0.8s ease-in-out',
            'slide-up': 'slideUp 0.6s ease-out',
            'float': 'float 4s ease-in-out infinite',
            'glow-pulse': 'glowPulse 2s ease-in-out infinite alternate',
            'matrix-rain': 'matrixRain 20s linear infinite',
            'neon-flicker': 'neonFlicker 1.5s ease-in-out infinite alternate'
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0', transform: 'translateY(20px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            slideUp: {
              '0%': { transform: 'translateY(30px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' }
            },
            float: {
              '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
              '50%': { transform: 'translateY(-15px) rotate(180deg)' }
            },
            glowPulse: {
              '0%': { boxShadow: '0 0 20px rgba(139, 92, 246, 0.3)' },
              '100%': { boxShadow: '0 0 40px rgba(139, 92, 246, 0.6)' }
            },
            matrixRain: {
              '0%': { transform: 'translateY(-100vh)' },
              '100%': { transform: 'translateY(100vh)' }
            },
            neonFlicker: {
              '0%': { textShadow: '0 0 10px currentColor, 0 0 20px currentColor' },
              '100%': { textShadow: '0 0 5px currentColor, 0 0 15px currentColor, 0 0 25px currentColor' }
            }
          },
          backdropBlur: {
            xs: '2px'
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Orbitron:wght@500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style type="text/tailwindcss">
    @layer utilities {
      .text-gradient {
        @apply bg-clip-text text-transparent bg-gradient-to-r from-neon-purple via-neon-pink to-neon-cyan;
      }
      .text-gradient-alt {
        @apply bg-clip-text text-transparent bg-gradient-to-r from-neon-cyan via-neon-green to-neon-purple;
      }
      .card-hover {
        @apply transform transition-all duration-700 hover:-translate-y-4 hover:scale-105;
      }
      .glass-effect {
        @apply bg-white/5 backdrop-blur-md border border-white/10;
      }
      .neon-border {
        @apply border border-neon-purple/50 shadow-lg shadow-neon-purple/25;
      }
      .page-btn {
        @apply px-6 py-3 rounded-full transition-all duration-500 transform hover:scale-110;
      }
      .page-active {
        @apply bg-gradient-to-r from-neon-purple to-neon-pink text-white font-bold shadow-lg shadow-neon-purple/50;
      }
      .page-inactive {
        @apply glass-effect text-premium-highlight hover:bg-white/10 hover:text-white;
      }
      .search-results-section {
        display: none;
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
        color: rgba(139, 92, 246, 0.2);
        font-family: 'Courier New', monospace;
        animation: matrixRain linear infinite;
        user-select: none;
      }
    }
  </style>
</head>
<body class="bg-premium-dark text-premium-text font-sans overflow-x-hidden">
  <!-- Matrix Background -->
  <div class="matrix-bg" id="matrixBg"></div>

  <!-- Premium Navigation -->
  <nav class="glass-effect sticky top-0 z-50 border-b border-neon-purple/20">
    <div class="max-w-8xl mx-auto px-6">
      <div class="relative flex items-center justify-between h-20">
        <!-- Logo/Brand -->
        <div class="flex-shrink-0 flex items-center">
          <a href="/" class="flex items-center space-x-4">
            <div class="relative">
              <i class="fas fa-play-circle text-4xl text-neon-purple animate-float"></i>
              <div class="absolute inset-0 animate-glow-pulse rounded-full"></div>
            </div>
            <span class="text-3xl font-display font-black tracking-wider text-gradient animate-neon-flicker">AnimeHub</span>
          </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:block">
          <div class="ml-10 flex items-center space-x-10">
            <a href="{{ url('/') }}" class="px-1 pt-1 pb-2 relative group font-semibold text-premium-text hover:text-white transition-all duration-500">
              <span class="relative z-10">Home</span>
              <span class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-neon-purple to-neon-pink w-0 group-hover:w-full transition-all duration-500 rounded-full"></span>
              <span class="absolute inset-0 bg-gradient-to-r from-neon-purple/10 to-neon-pink/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-lg -m-2"></span>
            </a>
            <a href="{{ route('genre.list') }}" class="px-1 pt-1 pb-2 relative group font-semibold text-premium-text hover:text-white transition-all duration-500">
              <span class="relative z-10">Genre</span>
              <span class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-neon-purple to-neon-pink w-0 group-hover:w-full transition-all duration-500 rounded-full"></span>
              <span class="absolute inset-0 bg-gradient-to-r from-neon-purple/10 to-neon-pink/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-lg -m-2"></span>
            </a>
            <a href="#" class="px-1 pt-1 pb-2 relative group font-semibold text-premium-text hover:text-white transition-all duration-500">
              <span class="relative z-10">Trending</span>
              <span class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-neon-purple to-neon-pink w-0 group-hover:w-full transition-all duration-500 rounded-full"></span>
              <span class="absolute inset-0 bg-gradient-to-r from-neon-purple/10 to-neon-pink/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-lg -m-2"></span>
            </a>
            <a href="#" class="px-1 pt-1 pb-2 relative group font-semibold text-premium-text hover:text-white transition-all duration-500">
              <span class="relative z-10">Collections</span>
              <span class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-neon-purple to-neon-pink w-0 group-hover:w-full transition-all duration-500 rounded-full"></span>
              <span class="absolute inset-0 bg-gradient-to-r from-neon-purple/10 to-neon-pink/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-lg -m-2"></span>
            </a>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden glass-effect p-3 rounded-lg neon-border" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars text-neon-purple"></i>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div class="collapse navbar-collapse md:hidden glass-effect rounded-lg mt-4 p-4" id="navbarNav">
        <ul class="navbar-nav space-y-2">
          <li class="nav-item">
            <a class="nav-link glass-effect p-3 rounded-lg hover:bg-white/10 transition-all duration-300 {{ request()->is('/') ? 'bg-gradient-to-r from-neon-purple to-neon-pink text-white' : 'text-premium-text' }}" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link glass-effect p-3 rounded-lg hover:bg-white/10 transition-all duration-300 text-premium-text" href="{{ route('genre.list') }}">Genre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link glass-effect p-3 rounded-lg hover:bg-white/10 transition-all duration-300 text-premium-text" href="#">Trending</a>
          </li>
          <li class="nav-item">
            <a class="nav-link glass-effect p-3 rounded-lg hover:bg-white/10 transition-all duration-300 text-premium-text" href="#">Collections</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative bg-gradient-to-br from-premium-dark via-premium-base to-premium-light overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-neon-purple/10 via-neon-pink/10 to-neon-cyan/10 animate-pulse"></div>
    <div class="max-w-7xl mx-auto px-6 py-24 md:py-40 relative z-10">
      <div class="text-center">
        <h1 class="text-5xl md:text-8xl font-display font-black mb-8 text-gradient animate-neon-flicker leading-tight">
          Discover Your Next<br>
          <span class="text-gradient-alt">Favorite Anime</span>
        </h1>
        <p class="text-xl md:text-2xl text-premium-highlight max-w-4xl mx-auto mb-12 leading-relaxed">
          Explore thousands of anime series from all genres, updated daily with the latest episodes.<br>
          <span class="text-neon-cyan font-semibold">Premium streaming experience awaits.</span>
        </p>
        <form id="searchForm" class="max-w-3xl mx-auto relative group">
          <div class="glass-effect rounded-full p-2 neon-border group-hover:shadow-2xl group-hover:shadow-neon-purple/50 transition-all duration-500">
            <input 
              type="text" 
              id="mainSearch" 
              name="query"
              placeholder="Search for anime titles, genres, characters..." 
              class="w-full px-8 py-5 rounded-full bg-transparent text-premium-text placeholder-premium-highlight focus:outline-none text-lg font-medium"
            >
            <button type="submit" class="absolute right-3 top-3 bg-gradient-to-r from-neon-purple to-neon-pink hover:from-neon-pink hover:to-neon-cyan text-white rounded-full px-8 py-4 font-bold transition-all duration-500 transform hover:scale-105 shadow-lg shadow-neon-purple/50">
              <i class="fas fa-search mr-2"></i>Search
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Search Results Section -->
  <section id="searchResults" class="search-results-section max-w-8xl mx-auto px-6 py-20">
    <div class="flex items-center justify-between mb-16">
      <div class="flex items-center space-x-6">
        <h2 class="text-4xl font-display font-bold text-gradient">
          Search Results
        </h2>
        <span class="glass-effect px-6 py-3 text-neon-cyan font-bold rounded-full neon-border" id="search-count">
          0 Results
        </span>
      </div>
      <button id="clearSearch" class="glass-effect px-6 py-3 rounded-full text-premium-highlight hover:text-white font-semibold flex items-center space-x-2 transition-all duration-300 hover:bg-white/10 neon-border">
        <span>Clear Search</span>
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-8" id="search-results-container">
      <!-- Results will be populated here -->
    </div>
  </section>

  <!-- Ongoing Anime Section -->
  <section id="ongoingSection" class="max-w-8xl mx-auto px-6 py-20">
    <div class="flex items-center justify-between mb-16">
      <div class="flex items-center space-x-6">
        <h2 class="text-4xl font-display font-bold text-gradient">
          Ongoing Anime
        </h2>
        <span class="glass-effect px-6 py-3 text-neon-green font-bold rounded-full neon-border" id="ongoing-count">
          {{ count($ongoing['animeList']) }} Series
        </span>
      </div>
      <a href="#" class="glass-effect px-6 py-3 rounded-full text-premium-highlight hover:text-white font-semibold flex items-center space-x-2 transition-all duration-500 hover:bg-white/10 neon-border group">
        <span>View All</span>
        <i class="fas fa-chevron-right transform group-hover:translate-x-1 transition-transform duration-300"></i>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-8" id="ongoing-container">
      @foreach ($ongoing['animeList'] as $index => $anime)
      <div class="anime-card glass-effect rounded-2xl overflow-hidden shadow-2xl card-hover group neon-border animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
        <div class="relative overflow-hidden h-80">
          <img 
            src="{{ $anime['thumb'] }}" 
            alt="{{ $anime['title'] }}" 
            class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:brightness-110"
            loading="lazy"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
          <div class="absolute inset-0 bg-gradient-to-t from-neon-purple/20 via-transparent to-neon-pink/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          
          <span class="absolute top-4 right-4 bg-gradient-to-r from-neon-purple to-neon-pink text-white text-sm px-3 py-1 rounded-full font-bold shadow-lg">
            <i class="fas fa-play mr-1"></i>{{ $anime['total_episode'] }}
          </span>
        
          
          <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
            <div class="flex flex-wrap gap-2 mb-4">
              @if(isset($anime['genre']))
                @foreach(array_slice(explode(',', $anime['genre']), 0, 3) as $genre)
                <span class="text-xs glass-effect text-neon-cyan px-3 py-1 rounded-full font-semibold border border-neon-cyan/30">
                  {{ trim($genre) }}
                </span>
                @endforeach
              @endif
            </div>
          </div>
        </div>
        
        <div class="p-6">
          <h3 class="font-bold text-premium-text mb-3 line-clamp-2 text-lg leading-tight group-hover:text-white transition-colors duration-300">{{ $anime['title'] }}</h3>
          <div class="flex justify-between items-center">
            <span class="text-sm text-neon-green font-semibold flex items-center">
              <i class="fas fa-circle mr-2 animate-pulse"></i>
              New Episode
            </span>
            <a 
              href="{{ route('anime.detail', $anime['endpoint']) }}" 
              class="bg-gradient-to-r from-neon-purple to-neon-pink hover:from-neon-pink hover:to-neon-cyan text-white px-4 py-2 rounded-full font-bold transition-all duration-500 transform hover:scale-105 shadow-lg hover:shadow-neon-purple/50 text-sm"
            >
              <i class="fas fa-play mr-1"></i> Watch
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-16 flex justify-center items-center">
      <nav class="glass-effect rounded-full p-2 neon-border">
        <ul class="pagination flex items-center space-x-2">
          @if ($ongoing['currentPage'] > 1)
          <li class="page-item">
            <a class="page-btn page-inactive" href="{{ url('/?ongoing_page=' . ($ongoing['currentPage'] - 1) . '&completed_page=' . $completed['currentPage']) }}">
              <i class="fas fa-chevron-left mr-2"></i>Prev
            </a>
          </li>
          @else
          <li class="page-item">
            <span class="page-btn opacity-50 cursor-not-allowed glass-effect text-premium-highlight">
              <i class="fas fa-chevron-left mr-2"></i>Prev
            </span>
          </li>
          @endif
          
          @for ($i = 1; $i <= min($ongoing['totalPages'], 7); $i++)
          <li class="page-item">
            <a class="page-btn {{ $ongoing['currentPage'] == $i ? 'page-active' : 'page-inactive' }}" href="{{ url('/?ongoing_page=' . $i . '&completed_page=' . $completed['currentPage']) }}">{{ $i }}</a>
          </li>
          @endfor
          
          @if ($ongoing['hasNextPage'])
          <li class="page-item">
            <a class="page-btn page-inactive" href="{{ url('/?ongoing_page=' . ($ongoing['currentPage'] + 1) . '&completed_page=' . $completed['currentPage']) }}">
              Next<i class="fas fa-chevron-right ml-2"></i>
            </a>
          </li>
          @else
          <li class="page-item">
            <span class="page-btn opacity-50 cursor-not-allowed glass-effect text-premium-highlight">
              Next<i class="fas fa-chevron-right ml-2"></i>
            </span>
          </li>
          @endif
        </ul>
      </nav>
    </div>
  </section>

  <!-- Completed Anime Section -->
  <section id="completedSection" class="max-w-8xl mx-auto px-6 py-20 relative">
    <div class="absolute inset-0 bg-gradient-to-r from-premium-base/50 to-premium-light/50 rounded-3xl"></div>
    <div class="relative z-10">
      <div class="flex items-center justify-between mb-16">
        <div class="flex items-center space-x-6">
          <h2 class="text-4xl font-display font-bold text-gradient-alt">
            Completed Anime
          </h2>
          <span class="glass-effect px-6 py-3 text-neon-cyan font-bold rounded-full neon-border" id="completed-count">
            {{ count($completed['animeList']) }} Series
          </span>
        </div>
        <a href="#" class="glass-effect px-6 py-3 rounded-full text-premium-highlight hover:text-white font-semibold flex items-center space-x-2 transition-all duration-500 hover:bg-white/10 neon-border group">
          <span>View All</span>
          <i class="fas fa-chevron-right transform group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-8" id="completed-container">
        @foreach ($completed['animeList'] as $index => $anime)
        <div class="anime-card glass-effect rounded-2xl overflow-hidden shadow-2xl card-hover group neon-border animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
          <div class="relative overflow-hidden h-80">
            <img 
              src="{{ $anime['thumb'] }}" 
              alt="{{ $anime['title'] }}" 
              class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:brightness-110"
              loading="lazy"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-neon-cyan/20 via-transparent to-neon-green/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <span class="absolute top-4 right-4 bg-gradient-to-r from-neon-cyan to-neon-green text-white text-sm px-3 py-1 rounded-full font-bold shadow-lg">
              <i class="fas fa-film mr-1"></i>{{ $anime['total_episode'] }}
            </span>
            

            
            <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
              <div class="flex flex-wrap gap-2 mb-4">
                @if(isset($anime['genre']))
                  @foreach(array_slice(explode(',', $anime['genre']), 0, 3) as $genre)
                  <span class="text-xs glass-effect text-neon-green px-3 py-1 rounded-full font-semibold border border-neon-green/30">
                    {{ trim($genre) }}
                  </span>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
          
          <div class="p-6">
            <h3 class="font-bold text-premium-text mb-3 line-clamp-2 text-lg leading-tight group-hover:text-white transition-colors duration-300">{{ $anime['title'] }}</h3>
            <div class="flex justify-between items-center">
              <span class="text-sm text-neon-green font-semibold flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                Full Series
              </span>
              <a 
                href="{{ route('anime.detail', $anime['endpoint']) }}" 
                class="bg-gradient-to-r from-neon-cyan to-neon-green hover:from-neon-green hover:to-emerald-500 text-white px-4 py-2 rounded-full font-bold transition-all duration-500 transform hover:scale-105 shadow-lg hover:shadow-neon-green/50 text-sm"
              >
                <i class="fas fa-play mr-1"></i> Watch
              </a>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="mt-16 flex justify-center items-center">
        <nav class="glass-effect rounded-full p-2 neon-border">
          <ul class="pagination flex items-center space-x-2">
            @if ($completed['currentPage'] > 1)
            <li class="page-item">
              <a class="page-btn page-inactive" href="{{ url('/?ongoing_page=' . $ongoing['currentPage'] . '&completed_page=' . ($completed['currentPage'] - 1)) }}">
                <i class="fas fa-chevron-left mr-2"></i>Prev
              </a>
            </li>
            @else
            <li class="page-item">
              <span class="page-btn opacity-50 cursor-not-allowed glass-effect text-premium-highlight">
                <i class="fas fa-chevron-left mr-2"></i>Prev
              </span>
            </li>
            @endif
            
            @for ($i = 1; $i <= min($completed['totalPages'], 7); $i++)
            <li class="page-item">
              <a class="page-btn {{ $completed['currentPage'] == $i ? 'page-active' : 'page-inactive' }}" href="{{ url('/?ongoing_page=' . $ongoing['currentPage'] . '&completed_page=' . $i) }}">{{ $i }}</a>
            </li>
            @endfor
            
            @if ($completed['hasNextPage'])
            <li class="page-item">
              <a class="page-btn page-inactive" href="{{ url('/?ongoing_page=' . $ongoing['currentPage'] . '&completed_page=' . ($completed['currentPage'] + 1)) }}">
                Next<i class="fas fa-chevron-right ml-2"></i>
              </a>
            </li>
            @else
            <li class="page-item">
              <span class="page-btn opacity-50 cursor-not-allowed glass-effect text-premium-highlight">
                Next<i class="fas fa-chevron-right ml-2"></i>
              </span>
            </li>
            @endif
          </ul>
        </nav>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Matrix background effect
      function createMatrix() {
        const matrixBg = document.getElementById('matrixBg');
        const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ♦♥♠♣';
        
        for (let i = 0; i < 50; i++) {
          const char = document.createElement('div');
          char.className = 'matrix-char';
          char.textContent = chars[Math.floor(Math.random() * chars.length)];
          char.style.left = Math.random() * 100 + '%';
          char.style.animationDuration = (Math.random() * 10 + 5) + 's';
          char.style.animationDelay = Math.random() * 2 + 's';
          char.style.fontSize = Math.random() * 10 + 12 + 'px';
          matrixBg.appendChild(char);
        }
      }
      createMatrix();

      // Search functionality
      const searchForm = document.getElementById("searchForm");
      const searchInput = document.getElementById("mainSearch");
      const searchResultsSection = document.getElementById("searchResults");
      const searchResultsContainer = document.getElementById("search-results-container");
      const searchCount = document.getElementById("search-count");
      const clearSearchBtn = document.getElementById("clearSearch");
      const ongoingSection = document.getElementById("ongoingSection");
      const completedSection = document.getElementById("completedSection");

      // Handle form submission
      searchForm.addEventListener("submit", function(e) {
        e.preventDefault();
        performSearch();
      });

      // Clear search results
      clearSearchBtn.addEventListener("click", function() {
        searchInput.value = "";
        searchResultsSection.style.display = "none";
        ongoingSection.style.display = "block";
        completedSection.style.display = "block";
      });

      function performSearch() {
        const filter = searchInput.value.trim();
        
        if (filter === "") {
          alert("Please enter a search term");
          return;
        }
        
        // Show loading state with enhanced UI
        searchResultsContainer.innerHTML = `
          <div class="col-span-full text-center py-20">
            <div class="relative inline-block">
              <i class="fas fa-spinner fa-spin text-6xl text-neon-purple mb-6"></i>
              <div class="absolute inset-0 animate-ping">
                <i class="fas fa-spinner text-6xl text-neon-pink opacity-20"></i>
              </div>
            </div>
            <h3 class="text-2xl font-bold text-gradient mb-2">Searching Universe...</h3>
            <p class="text-premium-text">Looking for "${filter}" across all dimensions</p>
          </div>
        `;
        
        searchResultsSection.style.display = "block";
        ongoingSection.style.display = "none";
        completedSection.style.display = "none";
        
        fetch(`/search?query=${encodeURIComponent(filter)}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          const allResults = [...data.ongoing, ...data.completed];
          renderSearchResults(allResults, filter);
        })
        .catch(error => {
          console.error('Error:', error);
          searchResultsContainer.innerHTML = `
            <div class="col-span-full text-center py-20">
              <div class="glass-effect rounded-2xl p-12 neon-border max-w-md mx-auto">
                <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-6"></i>
                <h3 class="text-2xl font-bold text-gradient mb-4">Search Failed</h3>
                <p class="text-premium-text mb-6">Unable to connect to anime database</p>
                <button onclick="location.reload()" class="bg-gradient-to-r from-neon-purple to-neon-pink text-white px-6 py-3 rounded-full font-bold hover:scale-105 transition-transform duration-300">
                  Try Again
                </button>
              </div>
            </div>
          `;
        });
      }

      function renderSearchResults(results, query) {
        searchCount.textContent = `${results.length} Results`;
        
        if (results.length === 0) {
          searchResultsContainer.innerHTML = `
            <div class="col-span-full text-center py-20">
              <div class="glass-effect rounded-2xl p-12 neon-border max-w-lg mx-auto">
                <i class="fas fa-search text-6xl text-neon-cyan mb-6"></i>
                <h3 class="text-3xl font-bold text-gradient mb-4">No Results Found</h3>
                <p class="text-premium-text mb-2">No anime found for "<span class="text-neon-pink font-semibold">${query}</span>"</p>
                <p class="text-premium-highlight mb-6">Try different keywords or browse by genre</p>
                <div class="flex gap-4 justify-center">
                  <button onclick="document.getElementById('mainSearch').focus()" class="bg-gradient-to-r from-neon-purple to-neon-pink text-white px-6 py-3 rounded-full font-bold hover:scale-105 transition-transform duration-300">
                    Search Again
                  </button>
                  <a href="{{ route('genre.list') }}" class="glass-effect text-premium-highlight hover:text-white px-6 py-3 rounded-full font-bold hover:bg-white/10 transition-all duration-300 neon-border">
                    Browse Genres
                  </a>
                </div>
              </div>
            </div>
          `;
          return;
        }
        
        searchResultsContainer.innerHTML = results.map((anime, index) => `
          <div class="anime-card glass-effect rounded-2xl overflow-hidden shadow-2xl card-hover group neon-border animate-fade-in" style="animation-delay: ${index * 0.05}s;">
            <div class="relative overflow-hidden h-80">
              <img 
                src="${anime.thumb}" 
                alt="${anime.title}" 
                class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:brightness-110"
                loading="lazy"
                onerror="this.src='https://via.placeholder.com/300x400/151520/8b5cf6?text=Image+Not+Found'"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
              <div class="absolute inset-0 bg-gradient-to-t from-neon-purple/20 via-transparent to-neon-pink/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
              
              <span class="absolute top-4 right-4 bg-gradient-to-r from-neon-purple to-neon-pink text-white text-sm px-3 py-1 rounded-full font-bold shadow-lg">
                <i class="fas fa-film mr-1"></i>${anime.total_episode}
              </span>
              
              ${anime.status && anime.status.toLowerCase().includes('completed') ? `
              <span class="absolute top-4 left-4 bg-gradient-to-r from-neon-green to-emerald-500 text-white text-sm px-3 py-1 rounded-full font-bold shadow-lg">
                <i class="fas fa-check-circle mr-1"></i>Complete
              </span>
              ` : `
              <span class="absolute top-4 left-4 bg-gradient-to-r from-neon-green to-neon-cyan text-white text-sm px-3 py-1 rounded-full font-bold shadow-lg animate-pulse">
                <i class="fas fa-circle mr-1 animate-pulse"></i>Live
              </span>
              `}
              
              <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                <div class="flex flex-wrap gap-2 mb-4">
                  ${anime.genre ? anime.genre.split(',').slice(0, 3).map(g => `
                    <span class="text-xs glass-effect text-neon-cyan px-3 py-1 rounded-full font-semibold border border-neon-cyan/30">
                      ${g.trim()}
                    </span>
                  `).join('') : ''}
                </div>
              </div>
            </div>
            
            <div class="p-6">
              <h3 class="font-bold text-premium-text mb-3 line-clamp-2 text-lg leading-tight group-hover:text-white transition-colors duration-300">${anime.title}</h3>
              <div class="flex justify-between items-center">
                <span class="text-sm font-semibold flex items-center ${anime.status && anime.status.toLowerCase().includes('completed') ? 'text-neon-green' : 'text-neon-cyan'}">
                  <i class="fas ${anime.status && anime.status.toLowerCase().includes('completed') ? 'fa-check-circle' : 'fa-circle'} mr-2 ${anime.status && anime.status.toLowerCase().includes('completed') ? '' : 'animate-pulse'}"></i>
                  ${anime.status && anime.status.toLowerCase().includes('completed') ? 'Complete' : 'Ongoing'}
                </span>
                <a 
                  href="/anime/${anime.endpoint}" 
                  class="bg-gradient-to-r ${anime.status && anime.status.toLowerCase().includes('completed') ? 'from-neon-cyan to-neon-green hover:from-neon-green hover:to-emerald-500' : 'from-neon-purple to-neon-pink hover:from-neon-pink hover:to-neon-cyan'} text-white px-4 py-2 rounded-full font-bold transition-all duration-500 transform hover:scale-105 shadow-lg hover:shadow-neon-purple/50 text-sm"
                >
                  <i class="fas fa-play mr-1"></i> Watch
                </a>
              </div>
            </div>
          </div>
        `).join('');
      }

      // Add smooth scrolling for anchor links
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

      // Add intersection observer for animations
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in');
          }
        });
      }, observerOptions);

      // Observe all anime cards
      document.querySelectorAll('.anime-card').forEach(card => {
        observer.observe(card);
      });

      // Enhanced lazy loading for images
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

      // Add particle effects on hover for cards
      document.querySelectorAll('.anime-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.filter = 'brightness(1.1) saturate(1.2)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.filter = 'brightness(1) saturate(1)';
        });
      });

      // Dynamic gradient animation for hero section
      const heroSection = document.querySelector('section');
      let gradientAngle = 0;
      
      setInterval(() => {
        gradientAngle += 1;
        if (heroSection) {
          heroSection.style.background = `linear-gradient(${gradientAngle}deg, #0a0a0f, #151520, #1f1f2e)`;
        }
      }, 100);
    });
  </script>
</body>
</html>