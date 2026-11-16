<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre | AnimeHub</title>
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
            .genre-tile {
                position: relative;
                background: linear-gradient(135deg, var(--tile-a), var(--tile-b));
                transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease;
            }
            .genre-tile:hover {
                transform: translateY(-4px) scale(1.03);
                box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            }
            .genre-tile::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,0.35) 100%);
            }
        }
    </style>
</head>
<body class="bg-ink-950 text-ink-faint min-h-screen">

    <!-- Navigation -->
    <nav id="mainNav" class="sticky top-0 z-50 bg-ink-950/95 backdrop-blur border-b border-ink-700">
        <div class="max-w-[1400px] mx-auto px-4 md:px-12">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="/" class="flex items-center gap-2 text-sm md:text-base text-ink-faint hover:text-white transition-colors duration-200">
                    <i class="fas fa-arrow-left"></i>
                    <span class="hidden sm:inline">Kembali ke Home</span>
                </a>

                <a href="/" class="display-face text-2xl md:text-3xl text-signal-red tracking-wide">AnimeHub</a>

                <a href="/" class="text-white hover:text-ink-faint transition-colors duration-200" aria-label="Home">
                    <i class="fas fa-home text-lg"></i>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto px-4 md:px-12 py-10 md:py-14">
        <div class="mb-8 md:mb-10">
            <h1 class="text-2xl md:text-4xl font-black text-white mb-2">Browse by Genre</h1>
            <p class="text-ink-muted text-sm md:text-base">Pilih genre favoritmu dan jelajahi koleksinya</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
            @php
                $tileColors = [
                    ['#7b1fa2', '#4a0e63'],
                    ['#0277bd', '#023a5c'],
                    ['#c62828', '#7a1414'],
                    ['#2e7d32', '#164a1a'],
                    ['#ef6c00', '#8f4200'],
                    ['#5e35b1', '#331e6b'],
                    ['#00838f', '#004d55'],
                    ['#ad1457', '#6b0d38'],
                ];
            @endphp
            @foreach($genres as $index => $genre)
                @php $pair = $tileColors[$index % count($tileColors)]; @endphp
                <a
                    href="{{ route('genre.show', $genre['endpoint']) }}"
                    class="genre-tile animate-rise rounded-lg h-28 md:h-32 flex items-center justify-center p-4 text-center overflow-hidden"
                    style="--tile-a: {{ $pair[0] }}; --tile-b: {{ $pair[1] }}; animation-delay: {{ min($index, 20) * 0.03 }}s;"
                >
                    <span class="relative z-10 text-white font-bold text-sm md:text-base leading-snug">{{ $genre['name'] }}</span>
                </a>
            @endforeach
        </div>
    </main>

</body>
</html>