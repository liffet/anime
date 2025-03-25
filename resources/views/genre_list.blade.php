<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Genre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .genre-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 800px;
            margin: auto;
            gap: 10px;
        }
        .genre-card {
            background: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }
        .genre-card:hover {
            transform: scale(1.05);
        }
        .genre-card a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Daftar Genre Anime</h1>

    <div class="genre-container">
        @if(!empty($genres) && count($genres) > 0)
            @foreach($genres as $genre)
                <div class="genre-card">
                    <a href="{{ url('/genre/' . urlencode($genre)) }}">{{ ucfirst($genre) }}</a>
                </div>
            @endforeach
        @else
            <p>Genre tidak ditemukan.</p>
        @endif
    </div>
</body>
</html>
