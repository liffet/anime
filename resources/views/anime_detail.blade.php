<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $animeDetail['title'] }} | AnimeHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Noto+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gray: {
                            850: '#1e293b',
                            950: '#0f172a'
                        }
                    },
                    fontFamily: {
                        sans: ['"Noto Sans"', 'sans-serif'],
                        display: ['"Poppins"', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .text-gradient {
                @apply bg-clip-text text-transparent bg-gradient-to-r from-gray-400 to-gray-200;
            }
            .episode-highlight {
                @apply before:absolute before:left-0 before:top-0 before:h-full before:w-1 before:bg-gradient-to-b before:from-gray-500 before:to-gray-300;
            }
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-200 font-sans">
    <!-- Navigation -->
    <nav class="bg-gray-900 border-b border-gray-700 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Back Button -->
                <a href="javascript:history.back()" class="flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="font-medium">Back</span>
                </a>
                
                <!-- Page Title -->
                <h1 class="text-xl font-display font-semibold truncate max-w-xs md:max-w-md lg:max-w-2xl">
                    {{ $animeDetail['title'] }}
                </h1>
                
                <!-- Placeholder for balance -->
                <div class="w-20"></div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8 animate-fade-in">
        <!-- Anime Header -->
        <div class="flex flex-col md:flex-row gap-8 mb-12">
            <!-- Anime Poster -->
            <div class="w-full md:w-1/3 lg:w-1/4">
                <img 
                    src="{{ $animeDetail['image'] }}" 
                    alt="{{ $animeDetail['title'] }}" 
                    class="w-full rounded-xl shadow-2xl object-cover h-96 md:h-auto transition-transform duration-500 hover:scale-105"
                    loading="lazy"
                >
            </div>
            
            <!-- Anime Details -->
            <div class="w-full md:w-2/3 lg:w-3/4">
                <div class="bg-gray-800 rounded-xl p-6 shadow-lg h-full">
                    <h2 class="text-2xl font-display font-bold mb-4 text-white">{{ $animeDetail['title'] }}</h2>
                    
                    <!-- Synopsis -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2 text-gray-400">Synopsis</h3>
                        <p class="text-gray-300 leading-relaxed">{{ $animeDetail['synopsis'] }}</p>
                    </div>
                    
                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-700/50 p-3 rounded-lg">
                            <p class="text-sm text-gray-400">Status</p>
                            <p class="font-medium">{{ $animeDetail['status'] ?? 'Unknown' }}</p>
                        </div>
                        <div class="bg-gray-700/50 p-3 rounded-lg">
                            <p class="text-sm text-gray-400">Total Episode</p>
                            <p class="font-medium">{{ count($animeDetail['episodes']) }}</p>
                        </div>
                        <div class="bg-gray-700/50 p-3 rounded-lg">
                            <p class="text-sm text-gray-400">Rating</p>
                            <p class="font-medium">{{ $animeDetail['rating'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <button class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-bookmark mr-2"></i> Add to List
                        </button>
                        <button class="bg-gray-600/20 hover:bg-gray-600/40 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-share-alt mr-2"></i> Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Episode List -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-display font-bold text-white">
                    <i class="fas fa-list-ul mr-2 text-gray-400"></i>
                    Episode List
                </h2>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-gray-700/30 text-gray-400 text-sm rounded-full">
                        {{ count($animeDetail['episodes']) }} Episodes
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($animeDetail['episodes'] as $episode)
                <a 
                    href="{{ url('/anime/' . $animeDetail['endpoint'] . '/episode/' . basename($episode['url']) . '/watch') }}" 
                    class="bg-gray-800 hover:bg-gray-700/50 rounded-lg p-4 shadow-md transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg group episode-highlight relative"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-white group-hover:text-gray-100 transition-colors duration-300">{{ $episode['title'] }}</h3>
                            <p class="text-sm text-gray-400">Episode {{ $loop->iteration }}</p>
                        </div>
                        <i class="fas fa-play-circle text-xl text-gray-500 group-hover:text-gray-300 transition-colors duration-300"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>