<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
        }
        .anime-card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .anime-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="text-white">
    <!-- Header -->
    <header class="bg-black/50 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-blue-400 hover:text-blue-300 transition-colors">
                        <i class="fas fa-home text-xl"></i>
                    </a>
                    <i class="fas fa-chevron-right text-gray-500"></i>
                    <a href="/genre" class="text-blue-400 hover:text-blue-300 transition-colors">
                        Genre
                    </a>
                    <i class="fas fa-chevron-right text-gray-500"></i>
                    <span class="text-white font-semibold">{{ ucfirst($genre) }}</span>
                </div>
                <a href="/genre" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-list mr-2"></i>All Genres
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        <!-- Genre Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                    {{ ucfirst($genre) }}
                </span>
            </h1>
            <p class="text-gray-400 text-lg">
                <i class="fas fa-film mr-2"></i>
                {{ count($animeList) }} anime ditemukan
            </p>
        </div>

        <!-- Anime Grid -->
        @if(!empty($animeList) && count($animeList) > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($animeList as $anime)
                    <div class="anime-card rounded-xl overflow-hidden group">
                        <div class="relative aspect-[3/4] overflow-hidden">
                            <img 
                                src="{{ $anime['thumb'] }}" 
                                alt="{{ $anime['title'] }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                loading="lazy"
                                onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=No+Cover'"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            
                            <!-- Episode Badge -->
                            <div class="absolute top-3 right-3 bg-blue-600/90 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                {{ $anime['total_episode'] }}
                            </div>
                            
                            <!-- Play Button (appears on hover) -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="/anime/{{ $anime['endpoint'] }}" class="bg-blue-600 hover:bg-blue-700 text-white w-16 h-16 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                                    <i class="fas fa-play text-xl ml-1"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-4">
                            <h3 class="font-semibold text-white mb-2 line-clamp-2 text-sm leading-tight">
                                {{ $anime['title'] }}
                            </h3>
                            
                            <!-- Genres -->
                            @if(!empty($anime['genre']) && $anime['genre'] !== 'Unknown')
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @php
                                        $genres = array_slice(explode(',', $anime['genre']), 0, 2);
                                    @endphp
                                    @foreach($genres as $g)
                                        <span class="text-xs bg-gray-700/50 text-gray-300 px-2 py-1 rounded-full">
                                            {{ trim($g) }}
                                        </span>
                                    @endforeach
                                    @if(count(explode(',', $anime['genre'])) > 2)
                                        <span class="text-xs text-gray-400">+{{ count(explode(',', $anime['genre'])) - 2 }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Action Button -->
                            <a href="/anime/{{ $anime['endpoint'] }}" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm py-2 px-4 rounded-lg text-center block transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-play mr-2"></i>Watch Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="text-6xl text-gray-600 mb-6">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-400 mb-4">Tidak ada anime ditemukan</h3>
                <p class="text-gray-500 mb-8">
                    Maaf, tidak ada anime dengan genre "{{ ucfirst($genre) }}" yang ditemukan.
                </p>
                <a href="/genre" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar Genre
                </a>
            </div>
        @endif
    </main>

    <!-- Debug Info (only in development) -->
    @if(config('app.debug'))
        <div class="fixed bottom-4 right-4 bg-black/80 text-white p-4 rounded-lg text-sm max-w-sm">
            <strong>Debug Info:</strong><br>
            Genre: {{ $genre }}<br>
            Total Anime: {{ count($animeList) }}<br>
            @if(!empty($animeList))
                Sample Genres: {{ implode(', ', array_slice(array_map(fn($a) => $a['genre'], $animeList), 0, 3)) }}
            @endif
        </div>
    @endif
</body>
</html>