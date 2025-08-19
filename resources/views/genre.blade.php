<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Genre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <a href="/" class="btn btn-secondary mb-3">Kembali ke Home</a>

    <ul class="list-group">
        @foreach($genres as $genre)
            <li class="list-group-item">
                <a href="{{ route('genre.show', $genre['endpoint']) }}" class="text-decoration-none">
                    {{ $genre['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
</body>
</html>
