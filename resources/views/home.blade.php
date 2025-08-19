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
              dark: '#121212',
              base: '#1E1E1E',
              light: '#2A2A2A',
              accent: '#3A3A3A',
              text: '#E0E0E0',
              highlight: '#7C7C7C'
            }
          },
          fontFamily: {
            sans: ['"Noto Sans"', 'sans-serif'],
            display: ['"Poppins"', 'sans-serif']
          },
          animation: {
            'fade-in': 'fadeIn 0.6s ease-in-out',
            'slide-up': 'slideUp 0.5s ease-out',
            'float': 'float 3s ease-in-out infinite'
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' }
            },
            slideUp: {
              '0%': { transform: 'translateY(20px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' }
            },
            float: {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%': { transform: 'translateY(-10px)' }
            }
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Noto+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style type="text/tailwindcss">
    @layer utilities {
      .text-gradient {
        @apply bg-clip-text text-transparent bg-gradient-to-r from-premium-highlight to-premium-text;
      }
      .card-hover {
        @apply transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl;
      }
      .page-btn {
        @apply px-4 py-2 rounded-full transition-colors duration-300;
      }
      .page-active {
        @apply bg-premium-highlight text-premium-dark font-medium;
      }
      .page-inactive {
        @apply bg-premium-accent/30 text-premium-highlight hover:bg-premium-accent/50;
      }
    }
  </style>
</head>
<body class="bg-premium-dark text-premium-text font-sans">
  <!-- Premium Navigation -->
  <nav class="bg-premium-base border-b border-premium-accent/30 sticky top-0 z-50 shadow-2xl">
    <div class="max-w-8xl mx-auto px-6">
      <div class="relative flex items-center justify-between h-20">
        <!-- Logo/Brand -->
        <div class="flex-shrink-0 flex items-center">
          <a href="/" class="flex items-center space-x-3">
            <i class="fas fa-play-circle text-3xl text-premium-highlight animate-float"></i>
            <span class="text-2xl font-display font-bold tracking-tight text-gradient">AnimeHub</span>
          </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:block">
          <div class="ml-10 flex items-center space-x-8">
            <a href="{{ url('/') }}" class="px-1 pt-1 pb-2 relative group font-medium text-premium-text hover:text-white transition-colors duration-300">
              <span>Home</span>
              <span class="absolute bottom-0 left-0 h-0.5 bg-premium-highlight w-0 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="{{ route('genre.list') }}" class="px-1 pt-1 pb-2 relative group font-medium text-premium-text hover:text-white transition-colors duration-300">
              <span>Genre</span>
              <span class="absolute bottom-0 left-0 h-0.5 bg-premium-highlight w-0 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="#" class="px-1 pt-1 pb-2 relative group font-medium text-premium-text hover:text-white transition-colors duration-300">
              <span>Trending</span>
              <span class="absolute bottom-0 left-0 h-0.5 bg-premium-highlight w-0 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="#" class="px-1 pt-1 pb-2 relative group font-medium text-premium-text hover:text-white transition-colors duration-300">
              <span>Collections</span>
              <span class="absolute bottom-0 left-0 h-0.5 bg-premium-highlight w-0 group-hover:w-full transition-all duration-300"></span>
            </a>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div class="collapse navbar-collapse md:hidden" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('genre.list') }}">Genre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Trending</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Collections</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative bg-gradient-to-b from-premium-accent/20 to-premium-dark">
    <div class="max-w-7xl mx-auto px-6 py-20 md:py-32">
      <div class="text-center">
        <h1 class="text-4xl md:text-6xl font-display font-bold mb-6 text-gradient">
          Discover Your Next Favorite Anime
        </h1>
        <p class="text-xl text-premium-highlight max-w-3xl mx-auto mb-10">
          Explore thousands of anime series from all genres, updated daily with the latest episodes.
        </p>
        <div class="max-w-2xl mx-auto relative">
          <input 
            type="text" 
            id="mainSearch" 
            placeholder="Search for anime titles, genres..." 
            class="w-full px-6 py-4 rounded-full border border-premium-accent/30 bg-premium-light text-premium-text focus:outline-none focus:ring-2 focus:ring-premium-highlight shadow-lg transition-all duration-300"
          >
          <button class="absolute right-2 top-2 bg-premium-highlight hover:bg-premium-text text-premium-dark rounded-full px-6 py-2 font-medium transition-all duration-300 transform hover:scale-105">
            Search
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Ongoing Anime Section -->
  <section class="max-w-8xl mx-auto px-6 py-16">
    <div class="flex items-center justify-between mb-12">
      <div class="flex items-center">
        <h2 class="text-3xl font-display font-bold text-premium-text mr-6">
          <span class="text-premium-highlight">//</span> Ongoing Anime
        </h2>
        <span class="px-4 py-1 bg-premium-accent/30 text-premium-highlight text-sm font-medium rounded-full" id="ongoing-count">
          {{ count($ongoing['animeList']) }} Series
        </span>
      </div>
      <a href="#" class="text-premium-highlight hover:text-white text-sm font-medium flex items-center transition-colors duration-300">
        View All <i class="fas fa-chevron-right ml-2"></i>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8" id="ongoing-container">
      @foreach ($ongoing['animeList'] as $anime)
      <div class="anime-card bg-premium-light rounded-xl overflow-hidden shadow-lg card-hover group animate-fade-in">
        <div class="relative overflow-hidden h-80">
          <img 
            src="{{ $anime['thumb'] }}" 
            alt="{{ $anime['title'] }}" 
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            loading="lazy"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          <span class="absolute top-3 right-3 bg-premium-dark/90 text-white text-xs px-2 py-1 rounded-full">
            {{ $anime['total_episode'] }}
          </span>
          <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
            <div class="flex flex-wrap gap-1 mb-2">
              @if(isset($anime['genre']))
                @foreach(explode(',', $anime['genre']) as $genre)
                <span class="text-xs bg-premium-accent/30 text-premium-highlight px-2 py-1 rounded-full genre-tag">
                  {{ trim($genre) }}
                </span>
                @endforeach
              @endif
            </div>
          </div>
        </div>
        <div class="p-4">
          <h3 class="font-semibold text-premium-text mb-1 truncate">{{ $anime['title'] }}</h3>
          <div class="flex justify-between items-center">
            <span class="text-xs text-premium-highlight">
              New Episode
            </span>
            <a 
              href="{{ route('anime.detail', $anime['endpoint']) }}" 
              class="text-xs bg-premium-accent hover:bg-premium-highlight text-premium-dark px-3 py-1 rounded-full transition-colors duration-300"
            >
              <i class="fas fa-play mr-1"></i> Watch
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-12 flex justify-center items-center space-x-2">
      <nav>
        <ul class="pagination">
          @if ($ongoing['currentPage'] > 1)
          <li class="page-item">
            <a class="page-link page-inactive" href="{{ url('/?ongoing_page=' . ($ongoing['currentPage'] - 1) . '&completed_page=' . $completed['currentPage']) }}">&laquo; Prev</a>
          </li>
          @else
          <li class="page-item disabled">
            <span class="page-link page-inactive opacity-50 cursor-not-allowed">&laquo; Prev</span>
          </li>
          @endif
          @for ($i = 1; $i <= $ongoing['totalPages']; $i++)
          <li class="page-item {{ $ongoing['currentPage'] == $i ? 'active' : '' }}">
            <a class="page-link {{ $ongoing['currentPage'] == $i ? 'page-active' : 'page-inactive' }}" href="{{ url('/?ongoing_page=' . $i . '&completed_page=' . $completed['currentPage']) }}">{{ $i }}</a>
          </li>
          @endfor
          @if ($ongoing['hasNextPage'])
          <li class="page-item">
            <a class="page-link page-inactive" href="{{ url('/?ongoing_page=' . ($ongoing['currentPage'] + 1) . '&completed_page=' . $completed['currentPage']) }}">Next &raquo;</a>
          </li>
          @else
          <li class="page-item disabled">
            <span class="page-link page-inactive opacity-50 cursor-not-allowed">Next &raquo;</span>
          </li>
          @endif
        </ul>
      </nav>
    </div>
  </section>

  <!-- Completed Anime Section -->
  <section class="max-w-8xl mx-auto px-6 py-16 bg-premium-base/50">
    <div class="flex items-center justify-between mb-12">
      <div class="flex items-center">
        <h2 class="text-3xl font-display font-bold text-premium-text mr-6">
          <span class="text-premium-highlight">//</span> Completed Anime
        </h2>
        <span class="px-4 py-1 bg-premium-accent/30 text-premium-highlight text-sm font-medium rounded-full" id="completed-count">
          {{ count($completed['animeList']) }} Series
        </span>
      </div>
      <a href="#" class="text-premium-highlight hover:text-white text-sm font-medium flex items-center transition-colors duration-300">
        View All <i class="fas fa-chevron-right ml-2"></i>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8" id="completed-container">
      @foreach ($completed['animeList'] as $anime)
      <div class="anime-card bg-premium-light rounded-xl overflow-hidden shadow-lg card-hover group animate-fade-in">
        <div class="relative overflow-hidden h-80">
          <img 
            src="{{ $anime['thumb'] }}" 
            alt="{{ $anime['title'] }}" 
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            loading="lazy"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          <span class="absolute top-3 right-3 bg-premium-dark/90 text-white text-xs px-2 py-1 rounded-full">
            {{ $anime['total_episode'] }}
          </span>
          <span class="absolute top-3 left-3 bg-green-600 text-white text-xs px-2 py-1 rounded-full">
            Completed
          </span>
          <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
            <div class="flex flex-wrap gap-1 mb-2">
              @if(isset($anime['genre']))
                @foreach(explode(',', $anime['genre']) as $genre)
                <span class="text-xs bg-premium-accent/30 text-premium-highlight px-2 py-1 rounded-full genre-tag">
                  {{ trim($genre) }}
                </span>
                @endforeach
              @endif
            </div>
          </div>
        </div>
        <div class="p-4">
          <h3 class="font-semibold text-premium-text mb-1 truncate">{{ $anime['title'] }}</h3>
          <div class="flex justify-between items-center">
            <span class="text-xs text-premium-highlight">
              Full Series
            </span>
            <a 
              href="{{ route('anime.detail', $anime['endpoint']) }}" 
              class="text-xs bg-premium-accent hover:bg-premium-highlight text-premium-dark px-3 py-1 rounded-full transition-colors duration-300"
            >
              <i class="fas fa-play mr-1"></i> Watch
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-12 flex justify-center items-center space-x-2">
      <nav>
        <ul class="pagination">
          @if ($completed['currentPage'] > 1)
          <li class="page-item">
            <a class="page-link page-inactive" href="{{ url('/?ongoing_page=' . $ongoing['currentPage'] . '&completed_page=' . ($completed['currentPage'] - 1)) }}">&laquo; Prev</a>
          </li>
          @else
          <li class="page-item disabled">
            <span class="page-link page-inactive opacity-50 cursor-not-allowed">&laquo; Prev</span>
          </li>
          @endif
          @for ($i = 1; $i <= $completed['totalPages']; $i++)
          <li class="page-item {{ $completed['currentPage'] == $i ? 'active' : '' }}">
            <a class="page-link {{ $completed['currentPage'] == $i ? 'page-active' : 'page-inactive' }}" href="{{ url('/?ongoing_page=' . $ongoing['currentPage'] . '&completed_page=' . $i) }}">{{ $i }}</a>
          </li>
          @endfor
          @if ($completed['hasNextPage'])
          <li class="page-item">
            <a class="page-link page-inactive" href="{{ url('/?ongoing_page=' . $ongoing['currentPage'] . '&completed_page=' . ($completed['currentPage'] + 1)) }}">Next &raquo;</a>
          </li>
          @else
          <li class="page-item disabled">
            <span class="page-link page-inactive opacity-50 cursor-not-allowed">Next &raquo;</span>
          </li>
          @endif
        </ul>
      </nav>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById("mainSearch");
      const searchButton = document.querySelector("#mainSearch + button");

      function performSearch() {
        const filter = searchInput.value.toLowerCase();
        
        if (filter.trim() === "") {
          window.location.href = "{{ url('/') }}";
          return;
        }

        fetch(`/search?query=${encodeURIComponent(filter)}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          renderSearchResults('ongoing', data.ongoing);
          renderSearchResults('completed', data.completed);
        })
        .catch(error => console.error('Error:', error));
      }

      function renderSearchResults(type, results) {
        const container = document.getElementById(`${type}-container`);
        const countEl = document.getElementById(`${type}-count`);
        const paginationEl = container.nextElementSibling;

        countEl.textContent = `${results.length} Results`;
        paginationEl.style.display = "none";

        container.innerHTML = results.map(anime => `
          <div class="anime-card bg-premium-light rounded-xl overflow-hidden shadow-lg card-hover group animate-fade-in">
            <div class="relative overflow-hidden h-80">
              <img 
                src="${anime.thumb}" 
                alt="${anime.title}" 
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
              <span class="absolute top-3 right-3 bg-premium-dark/90 text-white text-xs px-2 py-1 rounded-full">
                ${anime.total_episode}
              </span>
              ${type === 'completed' ? `
              <span class="absolute top-3 left-3 bg-green-600 text-white text-xs px-2 py-1 rounded-full">
                Completed
              </span>
              ` : ''}
              <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                <div class="flex flex-wrap gap-1 mb-2">
                  ${anime.genre.split(',').map(g => `
                    <span class="text-xs bg-premium-accent/30 text-premium-highlight px-2 py-1 rounded-full genre-tag">
                      ${g.trim()}
                    </span>
                  `).join('')}
                </div>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-premium-text mb-1 truncate">${anime.title}</h3>
              <div class="flex justify-between items-center">
                <span class="text-xs text-premium-highlight">
                  ${type === 'ongoing' ? 'New Episode' : 'Full Series'}
                </span>
                <a 
                  href="/anime/${anime.endpoint}" 
                  class="text-xs bg-premium-accent hover:bg-premium-highlight text-premium-dark px-3 py-1 rounded-full transition-colors duration-300"
                >
                  <i class="fas fa-play mr-1"></i> Watch
                </a>
              </div>
            </div>
          </div>
        `).join('');
      }

      searchInput.addEventListener("input", performSearch);
      searchButton.addEventListener("click", performSearch);
    });
  </script>
</body>
</html>