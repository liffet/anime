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
    <h2>Daftar Genre</h2>
    <ul class="list-group">
        @foreach ($genres as $genre)
            <li class="list-group-item">
                <a href="{{ route('genre.show', $genre['slug']) }}">
                    {{ $genre['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
</body>
</html>
