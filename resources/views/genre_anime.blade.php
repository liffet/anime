<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre: {{ $genreName }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Genre: {{ $genreName }}</h2>
    <div class="row">
        @foreach ($animeList as $anime)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ $anime['thumb'] }}" class="card-img-top" alt="{{ $anime['title'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $anime['title'] }}</h5>
                        <p>Episode: {{ $anime['total_episode'] }}</p>
                        <a href="{{ url('/anime/'.$anime['endpoint']) }}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
