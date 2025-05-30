<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $animeTitle ?? 'Nonton Anime' }} | AnimeHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Noto+Sans:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="bg-premium-dark text-premium-text font-sans min-h-screen">
    <nav class="bg-premium-base border-b border-premium-accent/30 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="javascript:history.back()" class="flex items-center text-premium-highlight hover:text-white transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="font-medium">Kembali</span>
                </a>
                <h1 class="text-xl font-display font-semibold truncate max-w-xs md:max-w-md lg:max-w-2xl">
                    {{ $animeTitle ?? 'Nonton Anime' }}
                </h1>
                <div class="w-20"></div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8 animate-fade-in flex flex-col items-center">
        <div class="w-full max-w-6xl mb-8">
            <div class="relative aspect-w-16 aspect-h-9 rounded-xl overflow-hidden shadow-2xl">
                <iframe id="videoPlayer" src="{{ $videoUrl ?? 'about:blank' }}" class="w-full h-96 md:h-[500px] lg:h-[600px] transition-transform duration-300" allowfullscreen></iframe>
            </div>
            <div id="serverInfo" class="mt-4 bg-premium-light/50 rounded-lg p-4 hidden">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-premium-highlight text-sm">Sedang diputar dari:</p>
                        <p id="serverNameDisplay" class="font-medium text-premium-text">-</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span id="resolutionBadge" class="px-2 py-1 bg-premium-accent/30 text-premium-highlight text-xs rounded-full">-</span>
                        <span id="qualityBadge" class="px-2 py-1 bg-premium-accent/30 text-premium-highlight text-xs rounded-full">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resolution and Server Selector -->
        <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-premium-light rounded-xl p-6 shadow-lg">
                <h2 class="text-lg font-display font-semibold mb-4 text-premium-text">
                    <i class="fas fa-tv mr-2 text-premium-highlight"></i>Pilih Resolusi
                </h2>
                <div class="flex flex-wrap gap-3" id="resolutionButtons"></div>
            </div>

            <div class="bg-premium-light rounded-xl p-6 shadow-lg">
                <h2 class="text-lg font-display font-semibold mb-4 text-premium-text">
                    <i class="fas fa-server mr-2 text-premium-highlight"></i>Pilih Server
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="serverButtons"></div>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-4 mt-6">
            <a href="/" class="px-6 py-3 bg-premium-accent hover:bg-premium-highlight text-premium-dark rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-home mr-2"></i> Kembali ke Home
            </a>
            <button id="fullscreenBtn" class="px-6 py-3 bg-premium-accent/30 hover:bg-premium-accent/50 text-premium-text rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-expand mr-2"></i> Layar Penuh
            </button>
            <button id="mirrorBtn" class="px-6 py-3 bg-premium-accent/30 hover:bg-premium-accent/50 text-premium-text rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-retweet mr-2"></i> Mirror Video
            </button>
        </div>
    </main>

    <script>
        let mirrors = {!! json_encode($mirrors ?? []) !!};

        const videoPlayer = document.getElementById('videoPlayer');
        const serverInfo = document.getElementById('serverInfo');
        const serverNameDisplay = document.getElementById('serverNameDisplay');
        const resolutionBadge = document.getElementById('resolutionBadge');
        const qualityBadge = document.getElementById('qualityBadge');
        const resolutionButtons = document.getElementById('resolutionButtons');
        const serverButtons = document.getElementById('serverButtons');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const mirrorBtn = document.getElementById('mirrorBtn');

        let isMirrored = false;

        function initPlayer() {
            if (Object.keys(mirrors).length === 0) {
                alert("Data video tidak tersedia!");
                return;
            }

            Object.keys(mirrors).forEach(resolution => {
                const btn = document.createElement('button');
                btn.className = 'px-4 py-2 bg-premium-accent/30 hover:bg-premium-accent/50 text-premium-text rounded-lg transition-all duration-300';
                btn.textContent = resolution;
                btn.dataset.resolution = resolution;

                btn.addEventListener('click', () => {
                    document.querySelectorAll('#resolutionButtons button').forEach(b => {
                        b.classList.remove('bg-premium-highlight', 'text-premium-dark');
                        b.classList.add('bg-premium-accent/30', 'text-premium-text');
                    });
                    btn.classList.add('bg-premium-highlight', 'text-premium-dark');

                    resolutionBadge.textContent = resolution;
                    loadServers(resolution);
                    localStorage.setItem('lastResolution', resolution);
                });

                resolutionButtons.appendChild(btn);
            });

            const savedResolution = localStorage.getItem('lastResolution');
            if (savedResolution && mirrors[savedResolution]) {
                document.querySelector(#resolutionButtons button[data-resolution="${savedResolution}"])?.click();

                setTimeout(() => {
                    const savedServer = localStorage.getItem('lastServer');
                    if (savedServer) {
                        const serverBtn = document.querySelector(#serverButtons button[data-url="${savedServer}"]);
                        serverBtn?.click();
                    }
                }, 300);
            } else {
                const firstResolution = Object.keys(mirrors)[0];
                document.querySelector(#resolutionButtons button[data-resolution="${firstResolution}"])?.click();
            }

            fullscreenBtn.addEventListener('click', () => {
                videoPlayer.requestFullscreen?.() || videoPlayer.webkitRequestFullscreen?.();
            });

            mirrorBtn.addEventListener('click', () => {
                isMirrored = !isMirrored;
                videoPlayer.style.transform = isMirrored ? 'scaleX(-1)' : 'scaleX(1)';
                mirrorBtn.innerHTML = isMirrored
                    ? '<i class="fas fa-retweet mr-2"></i> Unmirror Video'
                    : '<i class="fas fa-retweet mr-2"></i> Mirror Video';
            });
        }

        function loadServers(resolution) {
            serverButtons.innerHTML = '';

            if (mirrors[resolution]) {
                mirrors[resolution].forEach(mirror => {
                    const btn = document.createElement('button');
                    btn.className = 'px-3 py-2 bg-premium-accent/30 hover:bg-premium-accent/50 text-premium-text rounded-lg text-sm transition-all duration-300';
                    btn.textContent = mirror.source;
                    btn.dataset.url = mirror.link;
                    btn.dataset.quality = mirror.quality || 'HD';

                    btn.addEventListener('click', () => {
                        document.querySelectorAll('#serverButtons button').forEach(b => {
                            b.classList.remove('bg-premium-highlight', 'text-premium-dark');
                            b.classList.add('bg-premium-accent/30', 'text-premium-text');
                        });
                        btn.classList.add('bg-premium-highlight', 'text-premium-dark');
                        videoPlayer.src = mirror.link;
                        serverNameDisplay.textContent = mirror.source;
                        qualityBadge.textContent = mirror.quality || 'HD';
                        serverInfo.classList.remove('hidden');
                        resolutionBadge.textContent = resolution;
                        localStorage.setItem('lastServer', mirror.link);
                    });

                    serverButtons.appendChild(btn);
                });
            } else {
                serverButtons.innerHTML = '<p class="text-premium-highlight col-span-3">Tidak ada server tersedia untuk resolusi ini</p>';
            }
        }

        document.addEventListener('DOMContentLoaded', initPlayer);
    </script>
</body>
</html>


