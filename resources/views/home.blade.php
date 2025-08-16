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
            <span class="text-2xl font-display font-bold tracking-tight text-gradient">Anime</span>
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

        <!-- Search and User -->
       
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
          Loading...
        </span>
      </div>
      <a href="#" class="text-premium-highlight hover:text-white text-sm font-medium flex items-center transition-colors duration-300">
        View All <i class="fas fa-chevron-right ml-2"></i>
      </a>
    </div>

    <div id="ongoing-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
      <!-- Anime cards will be loaded here by JavaScript -->
    </div>

    <div id="ongoing-pagination" class="mt-12 flex justify-center items-center space-x-2">
      <!-- Pagination will be generated by JavaScript -->
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
          Loading...
        </span>
      </div>
      <a href="#" class="text-premium-highlight hover:text-white text-sm font-medium flex items-center transition-colors duration-300">
        View All <i class="fas fa-chevron-right ml-2"></i>
      </a>
    </div>

    <div id="completed-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
      <!-- Anime cards will be loaded here by JavaScript -->
    </div>

    <div id="completed-pagination" class="mt-12 flex justify-center items-center space-x-2">
      <!-- Pagination will be generated by JavaScript -->
    </div>
  </section>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Configuration
      const config = {
        itemsPerPage: 12,
        visiblePages: 5
      };

      // Sample data - in a real app, this would come from an API
      const animeData = {
        ongoing: [
          // This would be your ongoing anime data
          // Example:
          @foreach($ongoing as $anime)
          {
            title: "{{ $anime['title'] }}",
            thumb: "{{ $anime['thumb'] }}",
            endpoint: "{{ $anime['endpoint'] }}",
            total_episode: "{{ $anime['total_episode'] }}",
            genre: "{{ $anime['genre'] }}"
          },
          @endforeach
        ],
        completed: [
          // This would be your completed anime data
          @foreach($completed as $anime)
          {
            title: "{{ $anime['title'] }}",
            thumb: "{{ $anime['thumb'] }}",
            endpoint: "{{ $anime['endpoint'] }}",
            total_episode: "{{ $anime['total_episode'] }}",
            genre: "{{ $anime['genre'] }}"
          },
          @endforeach
        ]
      };

      // Initialize pagination
      initPagination('ongoing', animeData.ongoing);
      initPagination('completed', animeData.completed);

      // Search functionality
      const searchInput = document.getElementById("mainSearch");
      const searchButton = document.querySelector("#mainSearch + button");

      function performSearch() {
        const filter = searchInput.value.toLowerCase();
        
        if (filter.trim() === "") {
          // If search is empty, return to normal paginated view
          initPagination('ongoing', animeData.ongoing);
          initPagination('completed', animeData.completed);
          return;
        }

        // Search in all ongoing anime
        const ongoingResults = animeData.ongoing.filter(anime => {
          const titleMatch = anime.title.toLowerCase().includes(filter);
          const genreMatch = anime.genre.toLowerCase().includes(filter);
          return titleMatch || genreMatch;
        });

        // Search in all completed anime
        const completedResults = animeData.completed.filter(anime => {
          const titleMatch = anime.title.toLowerCase().includes(filter);
          const genreMatch = anime.genre.toLowerCase().includes(filter);
          return titleMatch || genreMatch;
        });

        // Display search results
        renderSearchResults('ongoing', ongoingResults);
        renderSearchResults('completed', completedResults);
      }

      searchInput.addEventListener("input", performSearch);
      searchButton.addEventListener("click", performSearch);

      function renderSearchResults(type, results) {
        const container = document.getElementById(`${type}-container`);
        const paginationEl = document.getElementById(`${type}-pagination`);
        const countEl = document.getElementById(`${type}-count`);
        
        // Update count
        countEl.textContent = `${results.length} Results`;
        
        // Hide pagination during search
        paginationEl.style.display = "none";
        
        // Render all matching results at once (no pagination)
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

      // Initialize pagination for a section
      function initPagination(type, data) {
        const container = document.getElementById(`${type}-container`);
        const paginationEl = document.getElementById(`${type}-pagination`);
        const countEl = document.getElementById(`${type}-count`);
        
        // Show pagination (might have been hidden during search)
        paginationEl.style.display = "flex";
        
        let currentPage = 1;
        const totalItems = data.length;
        const totalPages = Math.ceil(totalItems / config.itemsPerPage);

        // Update count
        countEl.textContent = `${totalItems} Series`;

        // Render initial items
        renderItems(type, data, currentPage);

        // Render pagination buttons
        renderPagination(type, currentPage, totalPages);

        // Handle pagination clicks
        paginationEl.addEventListener('click', function(e) {
          if (e.target.classList.contains('page-btn')) {
            currentPage = parseInt(e.target.dataset.page);
            renderItems(type, data, currentPage);
            renderPagination(type, currentPage, totalPages);
            window.scrollTo({
              top: container.offsetTop - 100,
              behavior: 'smooth'
            });
          }
        });
      }

      // Render anime items for a page
      function renderItems(type, data, page) {
        const container = document.getElementById(`${type}-container`);
        const start = (page - 1) * config.itemsPerPage;
        const end = start + config.itemsPerPage;
        const itemsToShow = data.slice(start, end);

        container.innerHTML = itemsToShow.map(anime => `
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

      // Render pagination buttons
      function renderPagination(type, currentPage, totalPages) {
        const paginationEl = document.getElementById(`${type}-pagination`);
        let html = '';

        // Previous button
        if (currentPage > 1) {
          html += `
            <button class="page-btn page-inactive" data-page="${currentPage - 1}">
              <i class="fas fa-chevron-left"></i>
            </button>
          `;
        } else {
          html += `
            <button class="page-btn page-inactive opacity-50 cursor-not-allowed" disabled>
              <i class="fas fa-chevron-left"></i>
            </button>
          `;
        }

        // Page numbers
        let startPage = Math.max(1, currentPage - Math.floor(config.visiblePages / 2));
        let endPage = Math.min(totalPages, startPage + config.visiblePages - 1);

        if (endPage - startPage + 1 < config.visiblePages) {
          startPage = Math.max(1, endPage - config.visiblePages + 1);
        }

        if (startPage > 1) {
          html += `
            <button class="page-btn page-inactive" data-page="1">1</button>
            ${startPage > 2 ? '<span class="px-2">...</span>' : ''}
          `;
        }

        for (let i = startPage; i <= endPage; i++) {
          html += `
            <button class="page-btn ${i === currentPage ? 'page-active' : 'page-inactive'}" data-page="${i}">
              ${i}
            </button>
          `;
        }

        if (endPage < totalPages) {
          html += `
            ${endPage < totalPages - 1 ? '<span class="px-2">...</span>' : ''}
            <button class="page-btn page-inactive" data-page="${totalPages}">${totalPages}</button>
          `;
        }

        // Next button
        if (currentPage < totalPages) {
          html += `
            <button class="page-btn page-inactive" data-page="${currentPage + 1}">
              <i class="fas fa-chevron-right"></i>
            </button>
          `;
        } else {
          html += `
            <button class="page-btn page-inactive opacity-50 cursor-not-allowed" disabled>
              <i class="fas fa-chevron-right"></i>
            </button>
          `;
        }

        paginationEl.innerHTML = html;
      }
    });
  </script>
</body>
</html>