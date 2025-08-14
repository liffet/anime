<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nonton Anime</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col items-center justify-center min-h-screen">

    <h1 class="text-2xl font-bold mb-4">{{ $animeTitle ?? 'Nonton Anime' }}</h1>

    <!-- Container Player -->
    <div class="w-full max-w-4xl">
        <div class="relative aspect-w-16 aspect-h-9" id="playerContainer">
            @if(preg_match('/\.(mp4|m3u8)$/', $videoUrl))
                <video id="videoPlayer" class="w-full h-96 rounded-lg shadow-lg" controls autoplay>
                    <source src="{{ $videoUrl }}" type="{{ Str::endsWith($videoUrl, '.m3u8') ? 'application/x-mpegURL' : 'video/mp4' }}">
                    Browser kamu tidak mendukung video tag.
                </video>
            @else
                <iframe id="videoPlayer" src="{{ $videoUrl }}" class="w-full h-96 rounded-lg shadow-lg" allowfullscreen></iframe>
            @endif
        </div>
    </div>

    <!-- List Mirror -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full max-w-5xl">
        @php
            $colors = [
                '360p' => 'bg-gray-600',
                '480p' => 'bg-sky-500',
                '720p' => 'bg-red-500',
                '1080p' => 'bg-green-500'
            ];
        @endphp

        @foreach($mirrors as $resolution => $servers)
            @if(count($servers) > 0)
                <div class="{{ $colors[$resolution] ?? 'bg-gray-700' }} p-4 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9.75 17h4.5m-5.25 3h6m-6-3h6M4 6h16M4 6v12a2 2 0 002 2h12a2 2 0 002-2V6" />
                        </svg>
                        Mirror {{ $resolution }}
                    </h2>
                    <div class="space-y-2">
                        @foreach($servers as $server)
                            <button 
                                data-link="{{ $server['link'] }}"
                                class="block w-full bg-gray-800 hover:bg-gray-900 px-3 py-2 rounded text-center transition">
                                {{ $server['source'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Tombol Kembali -->
    <a href="/" class="mt-6 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-700 transition">
        Kembali ke Home
    </a>

    <!-- Script -->
    <script>
        let playerContainer = document.getElementById('playerContainer');

        document.querySelectorAll('button[data-link]').forEach(btn => {
            btn.type = 'button';

            btn.addEventListener('click', () => {
                let link = btn.dataset.link;

                // List server yang memblokir iframe
                let blockedHosts = [
                    'mega.nz',
                    'drive.google.com',
                    'zippyshare.com',
                    'mediafire.com',
                    'acefile.co',
                    'otakufiles.net'
                ];

                let isBlocked = blockedHosts.some(host => link.includes(host));
                let isDirectVideo = /\.(mp4|m3u8)$/.test(link);

                if (isDirectVideo) {
                    // Ganti ke HTML5 video player
                    playerContainer.innerHTML = `
                        <video class="w-full h-96 rounded-lg shadow-lg" controls autoplay>
                            <source src="${link}" type="${link.endsWith('.m3u8') ? 'application/x-mpegURL' : 'video/mp4'}">
                            Browser kamu tidak mendukung video tag.
                        </video>
                    `;
                } else if (isBlocked) {
                    // Kalau iframe diblokir → buka di tab baru
                    window.open(link, '_blank');
                } else {
                    // Kalau bisa di-embed → iframe
                    playerContainer.innerHTML = `
                        <iframe src="${link}" class="w-full h-96 rounded-lg shadow-lg" allowfullscreen></iframe>
                    `;
                }
            });
        });
    </script>

</body>
</html>
