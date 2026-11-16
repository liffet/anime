<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $genreName }} Anime | AnimeHub</title>
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
            'rise': 'rise 0.5s ease-out both'
          },
          keyframes: {
            rise: {
              '0%': { transform: 'translateY(16px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' }
            }
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style type="text/tailwindcss">
    @layer base {
      body { font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif; }
      .display-face { font-family: 'Bebas Neue', 'Inter', sans-serif; letter-spacing: 0.02em; }
    }
    @layer utilities {
      .nav-scrolled { background-color: #0b0b0b; }
      .anime-card-inner {
        transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
      }
      .anime-card:hover .anime-card-inner {
        transform: translateY(-4px);
      }
      .btn-primary-nf {
        background: #ffffff;
        color: #0b0b0b;
      }
      .btn-primary-nf:hover { background: rgba(255,255,255,0.85); }
      .page-nav-btn {
        background: #181818;
        color: #e5e5e5;
        border: 1px solid #2f2f2f;
        transition: background-color 0.2s ease, border-color 0.2s ease;
      }
      .page-nav-btn:hover {
        background: #232323;
        border-color: #4a4a4a;
      }
      .page-current {
        background: #e50914;
        color: #ffffff;
        border-color: #e50914;
      }
    }
  </style>
</head>
<body class="bg-ink-950 text-ink-faint min-h-screen">

  <!-- Navigation -->
  <nav id="mainNav" class="sticky top-0 z-50 bg-ink-950/95 backdrop-blur border-b border-ink-700">
    <div class="max-w-[1800px] mx-auto px-4 md:px-12">
      <div class="flex items-center justify-between h-16 md:h-20">
        <a href="{{ route('genre.list') }}" class="flex items-center gap-2 text-sm md:text-base text-ink-faint hover:text-white transition-colors duration-200">
          <i class="fas fa-arrow-left"></i>
          <span class="hidden sm:inline">Semua Genre</span>
        </a>

        <a href="/" class="display-face text-2xl md:text-3xl text-signal-red tracking-wide">AnimeHub</a>

        <a href="/" class="text-white hover:text-ink-faint transition-colors duration-200" aria-label="Home">
          <i class="fas fa-home text-lg"></i>
        </a>
      </div>
    </div>
  </nav>

  <main class="max-w-[1800px] mx-auto px-4 md:px-12 py-10 md:py-14">
    <div class="mb-8 md:mb-10">
      <p class="text-signal-red text-xs md:text-sm font-semibold tracking-wide uppercase mb-1">Genre</p>
      <h1 class="text-2xl md:text-4xl font-black text-white mb-2">{{ $genreName }}</h1>
      <p class="text-ink-muted text-sm md:text-base">Discover amazing anime in this genre</p>
    </div>

    <!-- Anime Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6">
      @foreach ($animeList as $index => $anime)
        <a href="{{ url('/anime/'.$anime['endpoint']) }}" class="anime-card animate-rise" style="animation-delay: {{ min($index, 20) * 0.03 }}s;">
          <div class="anime-card-inner bg-ink-800 rounded-lg overflow-hidden shadow-lg">
            <div class="relative h-56 md:h-64">
              <img src="{{ $anime['thumb'] }}" alt="{{ $anime['title'] }}" class="w-full h-full object-cover" loading="lazy">
              <span class="absolute top-2 right-2 bg-ink-950/80 text-white text-xs px-2 py-1 rounded font-semibold">
                <i class="fas fa-play mr-1"></i>{{ $anime['total_episode'] }}
              </span>
            </div>
            <div class="p-3">
              <h3 class="text-white text-sm font-semibold line-clamp-2 mb-3 leading-snug">{{ $anime['title'] }}</h3>
              <span class="btn-primary-nf flex items-center justify-center gap-2 py-2 rounded text-xs font-bold w-full">
                <i class="fas fa-play"></i> Watch
              </span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    @if(count($animeList) === 0)
      <div class="text-center py-20">
        <i class="fas fa-film text-4xl text-ink-muted mb-4"></i>
        <p class="text-ink-faint">Belum ada anime untuk genre ini.</p>
      </div>
    @endif

    <!-- Pagination -->
    <div class="flex items-center justify-center gap-2 mt-12">
      @if ($currentPage > 1)
        <a href="{{ url('/genre/'.$genreName.'?page='.($currentPage - 1)) }}" class="page-nav-btn flex items-center gap-2 px-4 py-2 rounded text-sm font-semibold">
          <i class="fas fa-chevron-left"></i> Prev
        </a>
      @endif

      <span class="page-nav-btn page-current flex items-center px-4 py-2 rounded text-sm font-bold">
        {{ $currentPage }}
      </span>

      @if ($hasNextPage)
        <a href="{{ url('/genre/'.$genreName.'?page='.($currentPage + 1)) }}" class="page-nav-btn flex items-center gap-2 px-4 py-2 rounded text-sm font-semibold">
          Next <i class="fas fa-chevron-right"></i>
        </a>
      @endif
    </div>
  </main>

  <script>
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('loaded');
            observer.unobserve(entry.target);
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