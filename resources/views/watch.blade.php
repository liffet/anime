
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $animeTitle }} - AnimeHub</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #0b0b0b;
            color: white;
        }

        .server-btn {
            transition: .2s;
        }

        .server-btn.active {
            background: #e50914;
            border-color: #e50914;
        }
    </style>
</head>

<body class="min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-[#141414] border-b border-gray-800">
        <div class="max-w-6xl mx-auto px-5 py-5 flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-red-600">
                AnimeHub
            </a>

            <a href="/" class="text-sm text-gray-400 hover:text-white">
                Home
            </a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">

        <!-- TITLE -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold">
                {{ $animeTitle }}
            </h1>

            <p class="text-gray-400 mt-2">
                Episode {{ $episode }}
            </p>
        </div>

        <!-- VIDEO PLAYER -->
        <section class="bg-[#171717] rounded-xl overflow-hidden border border-gray-800">

            <div
                id="playerContainer"
                class="aspect-video bg-black flex items-center justify-center">

                @if(!empty($videoUrl))

                    @if(($videoType ?? 'iframe') === 'video')

                        <video
                            id="videoPlayer"
                            class="w-full h-full"
                            controls
                            playsinline
                            src="{{ $videoUrl }}">
                        </video>

                    @else

                        <div class="text-center p-6">
                            <div class="text-5xl mb-4">📺</div>

                            <h2 class="text-xl font-bold mb-3">
                                Streaming tersedia
                            </h2>

                            <p class="text-gray-400 text-sm mb-5">
                                Server ini tidak mengizinkan pemutaran di dalam halaman.
                            </p>

                            <a
                                href="{{ $videoUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-block bg-red-600 hover:bg-red-700
                                       px-6 py-3 rounded-lg font-bold transition">
                                Buka Streaming
                            </a>
                        </div>

                    @endif

                @else

                    <div class="text-center p-6">
                        <div class="text-5xl mb-4">📺</div>

                        <h2 class="text-xl font-bold mb-2">
                            Streaming belum tersedia
                        </h2>

                        <p class="text-gray-400 text-sm">
                            Belum ditemukan sumber streaming pada halaman episode ini.
                        </p>
                    </div>

                @endif

            </div>

        </section>

        @if(!empty($videoUrl))
            <p class="mt-3 text-xs text-gray-500">
                Video tidak muncul?
                <a href="{{ $videoUrl }}" target="_blank" rel="noopener noreferrer"
                   class="text-red-500 hover:underline">Buka di tab baru</a>
            </p>
        @endif

        <!-- STREAMING SERVER -->
        <section class="mt-8">

            <div class="flex items-center justify-between mb-4">

                <h2 class="text-xl font-bold">
                    Pilih Server Streaming
                </h2>

                <span class="text-xs text-gray-500">
                    {{ count($streamSources ?? []) }} server
                </span>

            </div>

            @if(!empty($streamSources))

                <div class="flex flex-wrap gap-3">

                    @foreach($streamSources as $index => $stream)

                        <button
                            type="button"
                            data-link="{{ $stream['link'] }}"
                            data-type="{{ $stream['type'] }}"
                            class="server-btn
                                   {{ $index === 0 ? 'active' : '' }}
                                   bg-[#222] border border-gray-700
                                   hover:bg-red-600 px-5 py-3
                                   rounded-lg text-sm font-semibold">

                            Server {{ $index + 1 }}

                        </button>

                    @endforeach

                </div>

                <p class="mt-4 text-sm text-gray-500">
                    Pilih server untuk mengganti sumber pemutaran.
                </p>

            @else

                <div class="bg-[#171717] border border-gray-800
                            rounded-lg p-5 text-gray-400">

                    Tidak ada sumber streaming yang ditemukan.

                </div>

            @endif

        </section>

        <!-- DOWNLOAD -->
        <section class="mt-10">

            <h2 class="text-xl font-bold mb-2">
                Download Anime
            </h2>

            <p class="text-gray-500 text-sm mb-5">
                Link download tersedia terpisah dari streaming.
            </p>

            @forelse(($mirrors ?? []) as $resolution => $servers)

                <div class="bg-[#171717] border border-gray-800
                            rounded-xl p-5 mb-4">

                    <h3 class="font-bold text-lg mb-4">
                        {{ $resolution }}
                    </h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3
                                md:grid-cols-4 gap-3">

                        @foreach($servers as $server)

                            <a
                                href="{{ $server['link'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="bg-[#252525] hover:bg-red-600
                                       text-center rounded-lg px-4 py-3
                                       text-sm transition">

                                {{ $server['source'] }}

                            </a>

                        @endforeach

                    </div>

                </div>

            @empty

                <div class="bg-[#171717] rounded-lg p-5 text-gray-400">
                    Link download tidak tersedia.
                </div>

            @endforelse

        </section>

        <!-- BACK HOME -->
        <div class="mt-10 text-center">

            <a href="/"
               class="inline-block bg-red-600 hover:bg-red-700
                      px-6 py-3 rounded-lg font-semibold transition">

                Kembali ke Home

            </a>

        </div>

    </main>

    <!-- SCRIPT -->
    <script>
        const playerContainer = document.getElementById('playerContainer');
        const serverButtons = document.querySelectorAll('.server-btn');

        function showIframePlayer(link) {
            playerContainer.innerHTML = '';

            const iframe = document.createElement('iframe');
            iframe.id = 'iframePlayer';
            iframe.className = 'w-full h-full';
            iframe.src = link;
            iframe.allowFullscreen = true;
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture');
            iframe.referrerPolicy = 'no-referrer-when-downgrade';

            playerContainer.appendChild(iframe);
        }

        function showVideoPlayer(link) {
            playerContainer.innerHTML = '';

            const video = document.createElement('video');
            video.id = 'videoPlayer';
            video.className = 'w-full h-full';
            video.controls = true;
            video.playsInline = true;
            video.src = link;

            playerContainer.appendChild(video);
            video.load();
        }

        serverButtons.forEach(button => {

            button.addEventListener('click', function () {

                const link = this.dataset.link;
                const type = this.dataset.type;

                if (!link) return;

                if (type === 'video') {
                    showVideoPlayer(link);
                } else {
                    showIframePlayer(link);
                }

                serverButtons.forEach(btn => {
                    btn.classList.remove('active');
                });

                this.classList.add('active');

            });

        });
    </script>

</body>
</html>
