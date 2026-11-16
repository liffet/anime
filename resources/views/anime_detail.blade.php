<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $animeDetail['title'] }} | AnimeHub</title>
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
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'rise': 'rise 0.5s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
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
            .hero-fade {
                background: linear-gradient(180deg, rgba(11,11,11,0.2) 0%, rgba(11,11,11,0.1) 30%, rgba(11,11,11,0.85) 82%, #0b0b0b 100%);
            }
            .hero-side-fade {
                background: linear-gradient(90deg, rgba(11,11,11,0.92) 0%, rgba(11,11,11,0.35) 45%, rgba(11,11,11,0.05) 75%);
            }
            .meta-chip {
                border: 1px solid rgba(255,255,255,0.25);
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
            .btn-icon-nf {
                width: 44px; height: 44px;
                border: 2px solid rgba(255,255,255,0.4);
                color: #ffffff;
            }
            .btn-icon-nf:hover { border-color: #ffffff; background: rgba(255,255,255,0.1); }
            .episode-card {
                background: #181818;
                transition: background-color 0.25s ease, transform 0.25s ease;
            }
            .episode-card:hover {
                background: #232323;
                transform: translateY(-2px);
            }
            .ep-number {
                font-family: 'Bebas Neue', sans-serif;
                color: #4a4a4a;
                transition: color 0.25s ease;
            }
            .episode-card:hover .ep-number { color: #e50914; }
        }
    </style>
</head>
<body class="bg-ink-950 text-ink-faint">

    <!-- Navigation -->
    <nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 transition-colors duration-300">
        <div class="max-w-[1800px] mx-auto px-4 md:px-12">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="javascript:history.back()" class="flex items-center gap-2 text-sm md:text-base text-ink-faint hover:text-white transition-colors duration-200">
                    <i class="fas fa-arrow-left"></i>
                    <span class="hidden sm:inline">Back to Browse</span>
                </a>

                <a href="/" class="display-face text-2xl md:text-3xl text-signal-red tracking-wide">AnimeHub</a>

                <a href="/" class="text-white hover:text-ink-faint transition-colors duration-200" aria-label="Home">
                    <i class="fas fa-home text-lg"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero / Detail header -->
    @php
        $posterUrl = $animeDetail['thumb']
            ?? $animeDetail['thumbnail']
            ?? $animeDetail['poster']
            ?? $animeDetail['image']
            ?? $animeDetail['cover']
            ?? null;
    @endphp
    <section class="relative min-h-[70vh] md:min-h-[80vh] w-full overflow-hidden">
        @if(!empty($posterUrl))
            <img src="{{ $posterUrl }}" alt="{{ $animeDetail['title'] }}" class="absolute inset-0 w-full h-full object-cover object-top">
        @else
            <div class="absolute inset-0 bg-ink-900"></div>
        @endif
        <div class="absolute inset-0 hero-side-fade"></div>
        <div class="absolute inset-0 hero-fade"></div>

        <div class="relative z-10 max-w-[1800px] mx-auto px-4 md:px-12 pt-28 md:pt-36 pb-12">
            <div class="flex flex-col md:flex-row gap-8 md:gap-10 items-start">
                <!-- Poster -->
                @if(!empty($posterUrl))
                <div class="hidden md:block flex-shrink-0 w-56 lg:w-64 rounded-lg overflow-hidden shadow-2xl ring-1 ring-white/10">
                    <img src="{{ $posterUrl }}" alt="{{ $animeDetail['title'] }}" class="w-full h-auto object-cover">
                </div>
                @endif

                <!-- Info -->
                <div class="max-w-2xl animate-fade-in">
                    <h1 class="text-3xl md:text-5xl font-black text-white leading-tight mb-4">{{ $animeDetail['title'] }}</h1>

                    <div class="flex flex-wrap items-center gap-2 mb-6">
                        <span class="meta-chip text-xs px-3 py-1 rounded">{{ $animeDetail['status'] ?? 'Unknown' }}</span>
                        <span class="meta-chip text-xs px-3 py-1 rounded">{{ count($animeDetail['episodes']) }} Episodes</span>
                        @if(!empty($animeDetail['rating']))
                            <span class="meta-chip text-xs px-3 py-1 rounded flex items-center gap-1">
                                <i class="fas fa-star text-signal-gold"></i> {{ $animeDetail['rating'] }}
                            </span>
                        @endif
                    </div>

                    @if(!empty($animeDetail['synopsis']))
                        <p class="text-ink-faint leading-relaxed mb-8 line-clamp-5 md:line-clamp-none">{{ $animeDetail['synopsis'] }}</p>
                    @endif

                    <div class="flex flex-wrap items-center gap-3">
                        @if(count($animeDetail['episodes']))
                            <a href="{{ url('/anime/' . $animeDetail['endpoint'] . '/episode/' . basename($animeDetail['episodes'][0]['url']) . '/watch') }}" class="btn-primary-nf flex items-center gap-2 px-6 py-3 rounded font-bold text-sm md:text-base transition-colors duration-200">
                                <i class="fas fa-play"></i> Play Episode 1
                            </a>
                        @endif
                        <button class="btn-ghost-nf flex items-center gap-2 px-6 py-3 rounded font-bold text-sm md:text-base transition-colors duration-200">
                            <i class="fas fa-plus"></i> My List
                        </button>
                        <button class="btn-icon-nf flex items-center justify-center rounded-full transition-colors duration-200" aria-label="Add to favorites">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="btn-icon-nf flex items-center justify-center rounded-full transition-colors duration-200" aria-label="Share">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Episode List -->
    <section class="max-w-[1800px] mx-auto px-4 md:px-12 py-10 md:py-14">
        <div class="flex items-baseline justify-between mb-6">
            <h2 class="text-lg md:text-2xl font-bold text-white">Episodes</h2>
            <span class="text-ink-muted text-xs md:text-sm">{{ count($animeDetail['episodes']) }} episodes</span>
        </div>

        <div class="flex flex-col divide-y divide-ink-700 rounded-lg overflow-hidden">
            @foreach($animeDetail['episodes'] as $index => $episode)
            <a
                href="{{ url('/anime/' . $animeDetail['endpoint'] . '/episode/' . basename($episode['url']) . '/watch') }}"
                class="episode-card flex items-center gap-5 px-5 py-4 animate-rise"
                style="animation-delay: {{ min($index, 20) * 0.03 }}s;"
            >
                <span class="ep-number text-3xl md:text-4xl w-12 text-center flex-shrink-0">{{ $loop->iteration }}</span>

                <div class="flex-1 min-w-0">
                    <h3 class="text-white font-semibold text-sm md:text-base truncate">Episode {{ $loop->iteration }}</h3>
                    <p class="text-ink-muted text-xs md:text-sm truncate">{{ $episode['title'] }}</p>
                </div>

                <span class="hidden sm:flex items-center gap-1 text-xs text-ink-muted flex-shrink-0">
                    <i class="fas fa-circle text-[6px] text-signal-red"></i> HD
                </span>

                <i class="fas fa-play text-ink-muted flex-shrink-0"></i>
            </a>
            @endforeach
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>

    <style>
        .line-clamp-5 {
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>