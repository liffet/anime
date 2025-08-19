<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $genreName }} Anime</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #111;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }
    .anime-card {
      background: #1c1c1c;
      border-radius: 12px;
      overflow: hidden;
      position: relative;
      transition: transform .2s;
    }
    .anime-card:hover {
      transform: translateY(-6px);
    }
    .anime-card img {
      width: 100%;
      height: 280px;
      object-fit: cover;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }
    .badge-episode {
      position: absolute;
      top: 10px;
      right: 10px;
      background: rgba(0,0,0,0.7);
      color: #fff;
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 0.8rem;
    }
    .anime-info {
      padding: 10px;
    }
    .anime-title {
      font-size: 1rem;
      font-weight: 600;
      margin: 0;
      color: #fff;
      text-overflow: ellipsis;
      white-space: nowrap;
      overflow: hidden;
    }
    .anime-footer {
      font-size: 0.8rem;
      color: #aaa;
    }
    .btn-watch {
      background: transparent;
      border: none;
      color: #aaa;
      font-size: 0.9rem;
    }
    .btn-watch:hover {
      color: #fff;
    }
  </style>
</head>
<body>
<div class="container py-4">
  <h3 class="mb-4">// {{ $genreName }} Anime</h3>
  <div class="row g-3">
    @foreach ($animeList as $anime)
      <div class="col-6 col-md-4 col-lg-3">
        <div class="anime-card h-100">
          <img src="{{ $anime['thumb'] }}" alt="{{ $anime['title'] }}">
          <span class="badge-episode">Episode {{ $anime['total_episode'] }}</span>
          <div class="anime-info">
            <h5 class="anime-title">{{ $anime['title'] }}</h5>
            <div class="anime-footer d-flex justify-content-between align-items-center mt-1">
              <span>New Episode</span>
              <a href="{{ url('/anime/'.$anime['endpoint']) }}" class="btn-watch">▶ Watch</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
</body>
</html>
