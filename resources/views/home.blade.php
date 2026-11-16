<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AnimeHub | Watch Anime Anytime</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ink: {
              950: '#0b0b0b',
              900: '#141414',
              800: '#181818',
              700: '#232323',
              600: '#2f2f2f',
              muted: '#808080',
              faint: '#b3b3b3'
            },
            signal: {
              red: '#e50914',
              redDark: '#b0060f',
              gold: '#f5c518'
            }
          },
          fontFamily: {
            sans: ['"Helvetica Neue"', 'Helvetica', 'Arial', 'sans-serif']
          },
          animation: {
            'rise': 'rise 0.5s ease-out',
            'fade-in': 'fadeIn 0.6s ease-out'
          },
          keyframes: {
            rise: {
              '0%': { transform: 'translateY(16px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' }
            },
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' }
            }
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style type="text/tailwindcss">
    @layer base {
      html { scroll-behavior: smooth; }
      body { font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif; }
      .display-face { font-family: 'Bebas Neue', 'Inter', sans-serif; letter-spacing: 0.02em; }
    }
    @layer utilities {
      .row-scroll {
        display: flex;
        gap: 0.6rem;
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none;
        padding: 0.5rem 0 1.5rem 0;
      }
      .row-scroll::-webkit-scrollbar { display: none; }
      .row-card {
        flex: 0 0 auto;
        width: 220px;
      }
      @media (min-width: 768px) { .row-card { width: 250px; } }
      .row-card-inner {
        transition: transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1), z-index 0s;
        transform-origin: center;
      }
      .row-card:hover .row-card-inner {
        transform: scale(1.12) translateY(-6px);
        z-index: 20;
        position: relative;
      }
      .row-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        letter-spacing: -0.01em;
      }
      .search-results-section { display: none; }
      .nav-scrolled { background-color: #0b0b0b; }
      .hero-fade {
        background: linear-gradient(180deg, rgba(11,11,11,0.15) 0%, rgba(11,11,11,0) 35%, rgba(11,11,11,0.6) 78%, #0b0b0b 100%);
      }
      .hero-side-fade {
        background: linear-gradient(90deg, rgba(11,11,11,0.85) 0%, rgba(11,11,11,0.15) 45%, rgba(11,11,11,0) 70%);
      }
      .chip {
        border: 1px solid rgba(255,255,255,0.35);
        color: #e5e5e5;
      }
      .btn-primary-nf {
        background: #ffffff;
        color: #0b0b0b;
      }
      .btn-primary-nf:hover { background: rgba(255,255,255,0.85); }
      .btn-ghost-nf {
        background: rgba(109,109,110,0.5);
        color: #ffffff;
      }
      .btn-ghost-nf:hover { background: rgba(109,109,110,0.75); }
      .page-dot {
        display: inline-block;
        width: 8px; height: 8px; border-radius: 999px;
        background: #3a3a3a;
        transition: width 0.25s ease, background-color 0.25s ease;
      }
      .page-dot:hover { background: #5a5a5a; }
      .page-dot.active { background: #e50914; width: 22px; }
    }
  </style>
</head>
<body class="bg-ink-950 text-ink-faint">

  <!-- Navigation -->
  <nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 transition-colors duration-300">
    <div class="max-w-[1800px] mx-auto px-4 md:px-12">
      <div class="flex items-center justify-between h-16 md:h-20">
        <div class="flex items-center gap-8">
          <a href="/" class="flex items-center gap-2">
            <span class="display-face text-3xl md:text-4xl text-signal-red tracking-wide">AnimeHub</span>
          </a>
          <div class="hidden md:flex items-center gap-6 text-sm text-ink-faint">
            <a href="{{ url('/') }}" class="hover:text-white transition-colors duration-200">Home</a>
            <a href="{{ route('genre.list') }}" class="hover:text-white transition-colors duration-200">Genre</a>
            <a href="#" class="hover:text-white transition-colors duration-200">Trending</a>
            <a href="#" class="hover:text-white transition-colors duration-200">Collections</a>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <button id="navSearchToggle" class="text-white hover:text-ink-faint transition-colors" aria-label="Search">
            <i class="fas fa-search text-lg"></i>
          </button>
          <button class="md:hidden text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-lg"></i>
          </button>
        </div>
      </div>

      <div class="collapse navbar-collapse md:hidden bg-ink-900 rounded-lg mb-3" id="navbarNav">
        <ul class="flex flex-col p-3 gap-1 text-sm">
          <li><a class="block p-3 rounded hover:bg-ink-700 {{ request()->is('/') ? 'text-white font-semibold' : 'text-ink-faint' }}" href="{{ url('/') }}">Home</a></li>
          <li><a class="block p-3 rounded hover:bg-ink-700 text-ink-faint" href="{{ route('genre.list') }}">Genre</a></li>
          <li><a class="block p-3 rounded hover:bg-ink-700 text-ink-faint" href="#">Trending</a></li>
          <li><a class="block p-3 rounded hover:bg-ink-700 text-ink-faint" href="#">Collections</a></li>
        </ul>
      </div>
    </div>

    <!-- Inline search bar, toggled -->
    <div id="navSearchBar" class="hidden max-w-[1800px] mx-auto px-4 md:px-12 pb-4">
      <form id="searchForm" class="relative max-w-xl">
        <input
          type="text"
          id="mainSearch"
          name="query"
          placeholder="Search titles, genres, characters"
          class="w-full bg-ink-950/90 border border-ink-600 focus:border-white rounded px-4 py-3 text-white placeholder-ink-muted focus:outline-none text-sm"
        >
        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted hover:text-white">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
  </nav>

  <!-- Hero -->
  @php
    $heroAnime = $ongoing['animeList'][0] ?? null;
  @endphp
  <section class="relative h-[62vh] md:h-[85vh] w-full overflow-hidden">
    @if($heroAnime)
      <img src="{{ $heroAnime['thumb'] }}" alt="{{ $heroAnime['title'] }}" class="absolute inset-0 w-full h-full object-cover object-top">
    @else
      <div class="absolute inset-0 bg-ink-900"></div>
    @endif
    <div class="absolute inset-0 hero-side-fade"></div>
    <div class="absolute inset-0 hero-fade"></div>

    <div class="relative z-10 h-full flex flex-col justify-end md:justify-center max-w-[1800px] mx-auto px-4 md:px-12 pb-16 md:pb-0">
      <div class="max-w-xl animate-fade-in">
        @if($heroAnime)
          <p class="text-signal-gold font-semibold text-sm mb-3 tracking-wide">New Episode Available</p>
          <h1 class="text-3xl md:text-6xl font-black text-white leading-tight mb-4">{{ $heroAnime['title'] }}</h1>
          @php $heroGenres = isset($heroAnime['genre']) ? array_filter(array_map('trim', explode(',', $heroAnime['genre']))) : []; @endphp
          @if(count($heroGenres))
            <div class="flex flex-wrap gap-2 mb-6">
              @foreach(array_slice($heroGenres, 0, 4) as $genre)
                <span class="chip text-xs px-3 py-1 rounded">{{ $genre }}</span>
              @endforeach
            </div>
          @endif
          <div class="flex items-center gap-3">
            <a href="{{ route('anime.detail', $heroAnime['endpoint']) }}" class="btn-primary-nf flex items-center gap-2 px-6 py-3 rounded font-bold text-sm md:text-base transition-colors duration-200">
              <i class="fas fa-play"></i> Watch Now
            </a>
            <a href="{{ route('anime.detail', $heroAnime['endpoint']) }}" class="btn-ghost-nf flex items-center gap-2 px-6 py-3 rounded font-bold text-sm md:text-base transition-colors duration-200">
              <i class="fas fa-circle-info"></i> More Info
            </a>
          </div>
        @else
          <h1 class="text-3xl md:text-6xl font-black text-white leading-tight mb-4">Discover Your Next Favorite Anime</h1>
          <p class="text-ink-faint mb-6">Thousands of series across every genre, updated daily.</p>
        @endif
      </div>
    </div>
  </section>

  <!-- Search Results -->
  <section id="searchResults" class="search-results-section max-w-[1800px] mx-auto px-4 md:px-12 pt-8 pb-16">
    <div class="flex items-center justify-between mb-6">
      <div class="flex items-baseline gap-4">
        <h2 class="row-title text-xl md:text-2xl text-white">Search Results</h2>
        <span class="text-ink-muted text-sm" id="search-count">0 results</span>
      </div>
      <button id="clearSearch" class="text-ink-faint hover:text-white text-sm flex items-center gap-2 transition-colors duration-200">
        Clear <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3" id="search-results-container"></div>
  </section>

  <!-- Ongoing Row -->
  <section id="ongoingSection" class="max-w-[1800px] mx-auto px-4 md:px-12 pt-6">
    <div class="flex items-baseline justify-between mb-2">
      <h2 class="row-title text-lg md:text-2xl text-white">Ongoing Anime</h2>
      <span class="text-ink-muted text-xs md:text-sm" id="ongoing-count">{{ count($ongoing['animeList']) }} series</span>
    </div>

    <div class="row-scroll" id="ongoing-container">
      @foreach ($ongoing['animeList'] as $index => $anime)
      <div class="row-card">
        <div class="row-card-inner bg-ink-800 rounded overflow-hidden shadow-lg">
          <div class="relative h-64 md:h-72">
            <img src="{{ $anime['thumb'] }}" alt="{{ $anime['title'] }}" class="w-full h-full object-cover" loading="lazy">
            <span class="absolute top-2 right-2 bg-ink-950/80 text-white text-xs px-2 py-1 rounded font-semibold">
              <i class="fas fa-play mr-1"></i>{{ $anime['total_episode'] }}
            </span>
            <span class="absolute top-2 left-2 bg-signal-red text-white text-[10px] px-2 py-1 rounded font-bold">ONGOING</span>
          </div>
          <div class="p-3">
            <h3 class="text-white text-sm font-semibold line-clamp-2 mb-2 leading-snug">{{ $anime['title'] }}</h3>
            @php $ongoingGenres = isset($anime['genre']) ? array_filter(array_map('trim', explode(',', $anime['genre']))) : []; @endphp
            @if(count($ongoingGenres))
              <div class="flex flex-wrap gap-1 mb-3">
                @foreach(array_slice($ongoingGenres, 0, 2) as $genre)
                  <span class="text-[10px] text-ink-muted border border-ink-600 px-2 py-0.5 rounded">{{ $genre }}</span>
                @endforeach
              </div>
            @else
              <div class="mb-3"></div>
            @endif
            <a href="{{ route('anime.detail', $anime['endpoint']) }}" class="btn-primary-nf flex items-center justify-center gap-2 py-2 rounded text-xs font-bold transition-colors duration-200">
              <i class="fas fa-play"></i> Watch
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="flex items-center justify-center gap-2 mt-2 mb-10">
      @for ($i = 1; $i <= min($ongoing['totalPages'], 7); $i++)
        <a href="{{ url('/?ongoing_page=' . $i . '&completed_page=' . $completed['currentPage']) }}" class="page-dot {{ $ongoing['currentPage'] == $i ? 'active' : '' }}" aria-label="Page {{ $i }}"></a>
      @endfor
    </div>
  </section>

  <!-- Completed Row -->
  <section id="completedSection" class="max-w-[1800px] mx-auto px-4 md:px-12 pb-16">
    <div class="flex items-baseline justify-between mb-2">
      <h2 class="row-title text-lg md:text-2xl text-white">Completed Anime</h2>
      <span class="text-ink-muted text-xs md:text-sm" id="completed-count">{{ count($completed['animeList']) }} series</span>
    </div>

    <div class="row-scroll" id="completed-container">
      @foreach ($completed['animeList'] as $index => $anime)
      <div class="row-card">
        <div class="row-card-inner bg-ink-800 rounded overflow-hidden shadow-lg">
          <div class="relative h-64 md:h-72">
            <img src="{{ $anime['thumb'] }}" alt="{{ $anime['title'] }}" class="w-full h-full object-cover" loading="lazy">
            <span class="absolute top-2 right-2 bg-ink-950/80 text-white text-xs px-2 py-1 rounded font-semibold">
              <i class="fas fa-film mr-1"></i>{{ $anime['total_episode'] }}
            </span>
            <span class="absolute top-2 left-2 bg-signal-gold text-ink-950 text-[10px] px-2 py-1 rounded font-bold">COMPLETE</span>
          </div>
          <div class="p-3">
            <h3 class="text-white text-sm font-semibold line-clamp-2 mb-2 leading-snug">{{ $anime['title'] }}</h3>
            @php $completedGenres = isset($anime['genre']) ? array_filter(array_map('trim', explode(',', $anime['genre']))) : []; @endphp
            @if(count($completedGenres))
              <div class="flex flex-wrap gap-1 mb-3">
                @foreach(array_slice($completedGenres, 0, 2) as $genre)
                  <span class="text-[10px] text-ink-muted border border-ink-600 px-2 py-0.5 rounded">{{ $genre }}</span>
                @endforeach
              </div>
            @else
              <div class="mb-3"></div>
            @endif
            <a href="{{ route('anime.detail', $anime['endpoint']) }}" class="btn-primary-nf flex items-center justify-center gap-2 py-2 rounded text-xs font-bold transition-colors duration-200">
              <i class="fas fa-play"></i> Watch
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="flex items-center justify-center gap-2 mt-2">
      @for ($i = 1; $i <= min($completed['totalPages'], 7); $i++)
        <a href="{{ url('/?ongoing_page=' . $ongoing['currentPage'] . '&completed_page=' . $i) }}" class="page-dot {{ $completed['currentPage'] == $i ? 'active' : '' }}" aria-label="Page {{ $i }}"></a>
      @endfor
    </div>
  </section>

  <footer class="max-w-[1800px] mx-auto px-4 md:px-12 py-10 text-ink-muted text-xs border-t border-ink-700">
    <p>AnimeHub — updated daily with the latest episodes.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Nav background on scroll
      const nav = document.getElementById('mainNav');
      function updateNav() {
        if (window.scrollY > 40) {
          nav.classList.add('nav-scrolled');
        } else {
          nav.classList.remove('nav-scrolled');
        }
      }
      updateNav();
      window.addEventListener('scroll', updateNav);

      // Search bar toggle
      const navSearchToggle = document.getElementById('navSearchToggle');
      const navSearchBar = document.getElementById('navSearchBar');
      navSearchToggle.addEventListener('click', function () {
        navSearchBar.classList.toggle('hidden');
        if (!navSearchBar.classList.contains('hidden')) {
          document.getElementById('mainSearch').focus();
        }
      });

      // Search functionality
      const searchForm = document.getElementById('searchForm');
      const searchInput = document.getElementById('mainSearch');
      const searchResultsSection = document.getElementById('searchResults');
      const searchResultsContainer = document.getElementById('search-results-container');
      const searchCount = document.getElementById('search-count');
      const clearSearchBtn = document.getElementById('clearSearch');
      const ongoingSection = document.getElementById('ongoingSection');
      const completedSection = document.getElementById('completedSection');

      searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
        performSearch();
      });

      clearSearchBtn.addEventListener('click', function () {
        searchInput.value = '';
        searchResultsSection.style.display = 'none';
        ongoingSection.style.display = 'block';
        completedSection.style.display = 'block';
      });

      function performSearch() {
        const filter = searchInput.value.trim();
        if (filter === '') {
          alert('Please enter a search term');
          return;
        }

        searchResultsContainer.innerHTML = `
          <div class="col-span-full text-center py-16">
            <i class="fas fa-spinner fa-spin text-4xl text-signal-red mb-4"></i>
            <p class="text-ink-faint">Searching for "${filter}"...</p>
          </div>
        `;

        searchResultsSection.style.display = 'block';
        ongoingSection.style.display = 'none';
        completedSection.style.display = 'none';
        window.scrollTo({ top: 0, behavior: 'smooth' });

        fetch(`/search?query=${encodeURIComponent(filter)}`, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
          .then(response => response.json())
          .then(data => {
            const allResults = [...data.ongoing, ...data.completed];
            renderSearchResults(allResults, filter);
          })
          .catch(error => {
            console.error('Error:', error);
            searchResultsContainer.innerHTML = `
              <div class="col-span-full text-center py-16">
                <i class="fas fa-exclamation-triangle text-4xl text-signal-red mb-4"></i>
                <h3 class="text-white font-bold mb-2">Search failed</h3>
                <p class="text-ink-faint mb-4">Unable to connect to the anime database</p>
                <button onclick="location.reload()" class="btn-primary-nf px-5 py-2 rounded font-bold text-sm">Try Again</button>
              </div>
            `;
          });
      }

      function renderSearchResults(results, query) {
        searchCount.textContent = `${results.length} results`;

        if (results.length === 0) {
          searchResultsContainer.innerHTML = `
            <div class="col-span-full text-center py-16">
              <i class="fas fa-search text-4xl text-ink-muted mb-4"></i>
              <h3 class="text-white font-bold mb-2">No results for "${query}"</h3>
              <p class="text-ink-faint mb-6">Try different keywords or browse by genre</p>
              <div class="flex gap-3 justify-center">
                <button onclick="document.getElementById('mainSearch').focus()" class="btn-primary-nf px-5 py-2 rounded font-bold text-sm">Search Again</button>
                <a href="{{ route('genre.list') }}" class="btn-ghost-nf px-5 py-2 rounded font-bold text-sm">Browse Genres</a>
              </div>
            </div>
          `;
          return;
        }

        searchResultsContainer.innerHTML = results.map((anime) => {
          const isComplete = anime.status && anime.status.toLowerCase().includes('completed');
          return `
          <div class="bg-ink-800 rounded overflow-hidden shadow-lg animate-rise">
            <div class="relative h-56 md:h-64">
              <img
                src="${anime.thumb}"
                alt="${anime.title}"
                class="w-full h-full object-cover"
                loading="lazy"
                onerror="this.src='https://via.placeholder.com/300x400/141414/808080?text=No+Image'"
              >
              <span class="absolute top-2 right-2 bg-ink-950/80 text-white text-xs px-2 py-1 rounded font-semibold">
                <i class="fas fa-film mr-1"></i>${anime.total_episode}
              </span>
              <span class="absolute top-2 left-2 ${isComplete ? 'bg-signal-gold text-ink-950' : 'bg-signal-red text-white'} text-[10px] px-2 py-1 rounded font-bold">
                ${isComplete ? 'COMPLETE' : 'ONGOING'}
              </span>
            </div>
            <div class="p-3">
              <h3 class="text-white text-sm font-semibold line-clamp-2 mb-3 leading-snug">${anime.title}</h3>
              <a href="/anime/${anime.endpoint}" class="btn-primary-nf flex items-center justify-center gap-2 py-2 rounded text-xs font-bold transition-colors duration-200">
                <i class="fas fa-play"></i> Watch
              </a>
            </div>
          </div>
        `;
        }).join('');
      }
    });
  </script>
</body>
</html>