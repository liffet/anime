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

    <div class="w-full max-w-4xl">
        <div class="relative aspect-w-16 aspect-h-9">
            <iframe id="videoPlayer" src="{{ $videoUrl }}" class="w-full h-96 rounded-lg shadow-lg" allowfullscreen></iframe>
        </div>
    </div>

    <div class="mt-6">
        <label for="resolutionSelect" class="block mb-2 text-lg">Pilih Resolusi:</label>
        <select id="resolutionSelect" class="px-4 py-2 rounded-lg bg-gray-700 text-white">
            <option value="">Pilih Resolusi</option>
        </select>
    </div>

    <div class="mt-4">
        <label for="serverSelect" class="block mb-2 text-lg">Pilih Server:</label>
        <select id="serverSelect" class="px-4 py-2 rounded-lg bg-gray-700 text-white" disabled>
            <option value="">Pilih Server</option>
        </select>
    </div>

    <a href="/" class="mt-6 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-700 transition">
        Kembali ke Home
    </a>

    <script>
        let mirrors = {!! json_encode($mirrors ?? []) !!};

        let resolutionSelect = document.getElementById('resolutionSelect');
        let serverSelect = document.getElementById('serverSelect');
        let videoPlayer = document.getElementById('videoPlayer');


        // Mengisi dropdown resolusi
        let availableResolutions = Object.keys(mirrors);
        if (availableResolutions.length > 0) {
            availableResolutions.forEach(resolution => {
                let option = document.createElement('option');
                option.value = resolution;
                option.textContent = resolution;
                resolutionSelect.appendChild(option);
            });
        }

        resolutionSelect.addEventListener('change', function() {
            let resolution = this.value;
            serverSelect.innerHTML = ''; // Hapus opsi lama

            let defaultOption = document.createElement('option');
            defaultOption.value = "";
            defaultOption.textContent = "Pilih Server";
            serverSelect.appendChild(defaultOption);

            if (mirrors[resolution] && mirrors[resolution].length > 0) {
                mirrors[resolution].forEach(mirror => {
                    let option = document.createElement('option');
                    option.value = mirror.link;
                    option.textContent = mirror.source;
                    serverSelect.appendChild(option);
                });

                serverSelect.disabled = false; // Aktifkan dropdown server
            } else {
                serverSelect.disabled = true; // Nonaktifkan jika tidak ada opsi
            }
        });

        serverSelect.addEventListener('change', function() {
            if (this.value) {
                videoPlayer.src = this.value;
            }
        });
    </script>

</body>
</html>
