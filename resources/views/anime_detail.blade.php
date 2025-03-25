<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Anime</title>
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
        img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
        }
        p {
            max-width: 800px;
            margin: auto;
            color: #555;
            line-height: 1.6;
        }
        ul {
            list-style: none;
            padding: 0;
            max-width: 600px;
            margin: auto;
        }
        li {
            background: white;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        li:hover {
            transform: translateY(-3px);
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
        }
        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            transition: color 0.3s;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>{{ $animeDetail['title'] }}</h1>
    <img src="{{ $animeDetail['image'] }}" alt="{{ $animeDetail['title'] }}">
    <p>{{ $animeDetail['synopsis'] }}</p>
    <h3>Daftar Episode</h3>
    <ul>
    @foreach($animeDetail['episodes'] as $episode)
        <li>
            <a href="{{ url('/anime/' . $animeDetail['endpoint'] . '/episode/' . basename($episode['url']) . '/watch') }}">
                {{ $episode['title'] }}
            </a>
        </li>
    @endforeach
    </ul>
</body>
</html>