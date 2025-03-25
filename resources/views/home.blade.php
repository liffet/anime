<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Anime</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }
    h1, h2 {
      color: #333;
    }
    nav {
      background: #007BFF;
      padding: 10px;
      text-align: center;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-size: 16px;
    }
    .anime-container {
      display: grid;
      /* Tetapkan ukuran tetap untuk setiap kartu */
      grid-template-columns: repeat(auto-fit, minmax(200px, 200px));
      gap: 20px;
      padding: 10px;
      max-width: 1000px;
      margin: auto;
      justify-content: center; /* Center-kan konten grid */
    }
    .anime-card {
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .anime-card:hover {
      transform: translateY(-5px);
      box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
    }
    .anime-card img {
      width: 100%;
      border-radius: 5px;
      height: auto;
    }
    .anime-card h3 {
      margin: 10px 0;
      color: #444;
    }
    .anime-card p {
      color: #666;
    }
    /* Styling untuk input search */
    #searchInput {
      width: 300px;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      font-size: 16px;
    }
  </style>
</head>
<body>

  <nav>
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/genre') }}">Genre</a>
  </nav>

  <h1>Daftar Anime</h1>
  <!-- Input search untuk pencarian secara real-time -->
  <input type="text" id="searchInput" placeholder="Cari anime...">

  <h2>Anime Ongoing</h2>
  <div class="anime-container" id="ongoingContainer">
    @foreach($ongoing as $anime)
      <div class="anime-card">
        <img src="{{ $anime['thumb'] }}" alt="{{ $anime['title'] }}">
        <h3>{{ $anime['title'] }}</h3>
        <p>{{ $anime['total_episode'] }}</p>
        <p><strong>Genre:</strong>
          @foreach(explode(',', $anime['genre']) as $g)
            <a href="{{ url('/genre/' . trim(strtolower($g))) }}" style="color: blue; text-decoration: none;">{{ trim($g) }}</a>
          @endforeach
        </p>
        <a href="{{ url('/anime/' . $anime['endpoint']) }}">Lihat Detail</a>
      </div>
    @endforeach
  </div>

  <h2>Anime Completed</h2>
  <div class="anime-container" id="completedContainer">
    @foreach($completed as $anime)
      <div class="anime-card">
        <img src="{{ $anime['thumb'] }}" alt="{{ $anime['title'] }}">
        <h3>{{ $anime['title'] }}</h3>
        <p>{{ $anime['total_episode'] }}</p>
        <p><strong>Genre:</strong>
          @foreach(explode(',', $anime['genre']) as $g)
            <a href="{{ url('/genre/' . trim(strtolower($g))) }}" style="color: blue; text-decoration: none;">{{ trim($g) }}</a>
          @endforeach
        </p>
        <a href="{{ url('/anime/' . $anime['endpoint']) }}">Lihat Detail</a>
      </div>
    @endforeach
  </div>

  <script>
    // Pencarian real-time
    const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("input", function() {
      const filter = searchInput.value.toLowerCase();
      const cards = document.querySelectorAll(".anime-card");

      cards.forEach(function(card) {
        const title = card.querySelector("h3").textContent.toLowerCase();
        if (title.indexOf(filter) > -1) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    });
  </script>

</body>
</html>