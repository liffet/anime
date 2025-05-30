<!DOCTYPE html>
<html lang="id">
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
  <style type="text/tailwindcss">
    @layer utilities {
      .text-gradient {
        @apply bg-clip-text text-transparent bg-gradient-to-r from-premium-highlight to-premium-text;
      }
      .card-hover {
        @apply transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl;
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
            <a href="{{ url('/genre') }}" class="px-1 pt-1 pb-2 relative group font-medium text-premium-text hover:text-white transition-colors duration-300">
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

        <!-- Search and User -->
        <div class="hidden md:flex items-center space-x-6">
          <div class="relative">
            <input 
              type="text" 
              placeholder="Search anime..." 
              class="bg-premium-light border border-premium-accent/30 rounded-full py-2 px-4 pl-10 text-sm text-premium-text focus:outline-none focus:ring-2 focus:ring-premium-highlight w-64 transition-all duration-300"
            >
            <i class="fas fa-search absolute left-3 top-3 text-premium-highlight"></i>
          </div>
          <button class="bg-premium-accent hover:bg-premium-highlight text-white px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-user mr-2"></i>Sign In
          </button>
        </div>
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
        <span class="px-4 py-1 bg-premium-accent/30 text-premium-highlight text-sm font-medium rounded-full">
          {{ count($ongoing) }} Series
        </span>
      </div>
      <a href="#" class="text-premium-highlight hover:text-white text-sm font-medium flex items-center transition-colors duration-300">
        View All <i class="fas fa-chevron-right ml-2"></i>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
      @foreach($ongoing as $anime)
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
              @foreach(explode(',', $anime['genre']) as $g)
                <span class="text-xs bg-premium-accent/30 text-premium-highlight px-2 py-1 rounded-full">
                  {{ trim($g) }}
                </span>
              @endforeach
            </div>
          </div>
        </div>
        <div class="p-4">
           <a 
              href="{{ url('/anime/' . $anime['endpoint']) }}" 
              class="text-xs bg-premium-accent hover:bg-premium-highlight text-premium-dark px-3 py-1 rounded-full transition-colors duration-300"
            >
          
            <h3 class="font-semibold text-premium-text mb-1 truncate">{{ $anime['title'] }}</h3>
            <div class="flex justify-between items-center">
            <span class="text-xs text-premium-highlight">New Episode</span>
          </a>
            <a 
              href="{{ url('/anime/' . $anime['endpoint']) }}" 
              class="text-xs bg-premium-accent hover:bg-premium-highlight text-premium-dark px-3 py-1 rounded-full transition-colors duration-300"
            >
              <i class="fas fa-play mr-1"></i> Watch
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  <!-- Completed Anime Section -->
  <section class="max-w-8xl mx-auto px-6 py-16 bg-premium-base/50">
    <div class="flex items-center justify-between mb-12">
      <div class="flex items-center">
        <h2 class="text-3xl font-display font-bold text-premium-text mr-6">
          <span class="text-premium-highlight">//</span> Completed Anime
        </h2>
        <span class="px-4 py-1 bg-premium-accent/30 text-premium-highlight text-sm font-medium rounded-full">
          {{ count($completed) }} Series
        </span>
      </div>
      <a href="#" class="text-premium-highlight hover:text-white text-sm font-medium flex items-center transition-colors duration-300">
        View All <i class="fas fa-chevron-right ml-2"></i>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
      @foreach($completed as $anime)
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
              @foreach(explode(',', $anime['genre']) as $g)
                <span class="text-xs bg-premium-accent/30 text-premium-highlight px-2 py-1 rounded-full">
                  {{ trim($g) }}
                </span>
              @endforeach
            </div>
          </div>
        </div>
        <div class="p-4">
          <h3 class="font-semibold text-premium-text mb-1 truncate">{{ $anime['title'] }}</h3>
          <div class="flex justify-between items-center">
            <span class="text-xs text-premium-highlight">Full Series</span>
            <a 
              href="{{ url('/anime/' . $anime['endpoint']) }}" 
              class="text-xs bg-premium-accent hover:bg-premium-highlight text-premium-dark px-3 py-1 rounded-full transition-colors duration-300"
            >
              <i class="fas fa-play mr-1"></i> Watch
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-premium-base border-t border-premium-accent/30 py-12">
    <div class="max-w-8xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-xl font-display font-bold text-gradient mb-4">AnimeHub</h3>
          <p class="text-sm text-premium-highlight">
            Your premium destination for anime streaming. Thousands of series at your fingertips.
          </p>
        </div>
        <div>
          <h4 class="text-premium-text font-medium mb-4">Navigation</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-sm text-premium-highlight hover:text-white transition-colors duration-300">Home</a></li>
            <li><a href="#" class="text-sm text-premium-highlight hover:text-white transition-colors duration-300">Genre</a></li>
            <li><a href="#" class="text-sm text-premium-highlight hover:text-white transition-colors duration-300">Trending</a></li>
            <li><a href="#" class="text-sm text-premium-highlight hover:text-white transition-colors duration-300">Collections</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-premium-text font-medium mb-4">Legal</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-sm text-premium-highlight hover:text-white transition-colors duration-300">Terms of Service</a></li>
            <li><a href="#" class="text-sm text-premium-highlight hover:text-white transition-colors duration-300">Privacy Policy</a></li>
            <li><a href="#" class="text-sm text-premium-highlight hover:text-white transition-colors duration-300">DMCA</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-premium-text font-medium mb-4">Connect</h4>
          <div class="flex space-x-4">
            <a href="#" class="text-premium-highlight hover:text-white transition-colors duration-300"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-premium-highlight hover:text-white transition-colors duration-300"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-premium-highlight hover:text-white transition-colors duration-300"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-premium-highlight hover:text-white transition-colors duration-300"><i class="fab fa-discord"></i></a>
          </div>
        </div>
      </div>
      <div class="border-t border-premium-accent/30 mt-12 pt-8 text-center text-sm text-premium-highlight">
        © 2023 AnimeHub. All rights reserved.
      </div>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Search functionality
      const searchInput = document.getElementById("mainSearch");
      const animeCards = document.querySelectorAll(".anime-card");
      
      searchInput.addEventListener("input", function() {
        const filter = searchInput.value.toLowerCase();
        
        animeCards.forEach(function(card) {
          const title = card.querySelector("h3").textContent.toLowerCase();
          const genres = card.querySelectorAll(".text-xs.bg-premium-accent");
          let genreMatch = false;
          
          genres.forEach(genre => {
            if (genre.textContent.toLowerCase().includes(filter)) {
              genreMatch = true;
            }
          });
          
          if (title.includes(filter) || genreMatch) {
            card.style.display = "block";
            card.classList.add("animate-slide-up");
          } else {
            card.style.display = "none";
          }
        });
      });

      // Intersection Observer for animations
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("animate-fade-in");
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      document.querySelectorAll('.anime-card').forEach(card => {
        observer.observe(card);
      });
    });
  </script>
</body>
</html>