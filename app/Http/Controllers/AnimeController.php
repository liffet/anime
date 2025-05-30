<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class AnimeController extends Controller
{
    private $client;
    private $baseUrl = "https://otakudesu.cloud";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index()
    {
        $ongoing = $this->getOngoingAnime();
        $completed = $this->getCompletedAnime();
    
        return view('home', compact('ongoing', 'completed'));
    }

    public function getOngoing()
    {
        return response()->json($this->getOngoingAnime());
    }

    public function getCompleted()
    {
        return response()->json($this->getCompletedAnime());
    }

    private function getOngoingAnime()
    {
        return $this->fetchAnimeList("$this->baseUrl/ongoing-anime/");
    }

    private function getCompletedAnime()
    {
        return $this->fetchAnimeList("$this->baseUrl/complete-anime/");
    }

    private function fetchAnimeList($url)
    {
        try {
            $animeList = [];
            $client = new Client();
    
            while ($url) {
                $response = $client->get($url, [
                    'headers' => ['User-Agent' => 'Mozilla/5.0'],
                    'verify' => false
                ]);
    
                $html = $response->getBody()->getContents();
                $crawler = new Crawler($html);
    
                $crawler->filter('.venz > ul > li')->each(function (Crawler $node) use (&$animeList) {
                    $genres = $node->filter('.set > a')->each(function (Crawler $genreNode) {
                        return trim($genreNode->text());
                    });
    
                    $animeData = [
                        'title' => $node->filter('h2')->count() > 0 ? trim($node->filter('h2')->text()) : 'Unknown',
                        'thumb' => $node->filter('img')->count() > 0 ? $node->filter('img')->attr('src') : 'https://via.placeholder.com/200',
                        'total_episode' => $node->filter('.epz')->count() > 0 ? trim($node->filter('.epz')->text()) : 'N/A',
                        'endpoint' => $node->filter('a')->count() > 0 ? str_replace(["$this->baseUrl/anime/", "/"], "", $node->filter('a')->attr('href')) : '',
                        'genre' => !empty($genres) ? implode(', ', $genres) : '', 
                    ];
    
                    // DEBUG: Cek apakah genre berhasil diambil
                    \Log::info("Anime ditemukan: " . json_encode($animeData));
    
                    $animeList[] = $animeData;
                });
    
                $nextPage = $crawler->filter('.pagination a.next')->count() > 0
                    ? $crawler->filter('.pagination a.next')->attr('href')
                    : null;
    
                if (!$nextPage) {
                    break;
                }
    
                $url = $nextPage;
            }
    
            return $animeList;
        } catch (\Exception $e) {
            \Log::error("Error saat scraping: " . $e->getMessage());
            return [];
        }
    }
    

    public function getAnimeDetail($endpoint)
{
    try {
        $url = "$this->baseUrl/anime/$endpoint/";

        $response = $this->client->get($url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0'
            ],
            'verify' => false
        ]);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $title = $crawler->filter('h1')->count() > 0 ? $crawler->filter('h1')->text() : 'Unknown Title';
        $image = $crawler->filter('.anime-thumbnail img')->count() > 0 ? $crawler->filter('.anime-thumbnail img')->attr('src') : '';
        $synopsis = $crawler->filter('.anime-synopsis p')->count() > 0 ? $crawler->filter('.anime-synopsis p')->text() : 'Tidak ada sinopsis';

        // Ambil daftar episode
        $episodes = [];
        $crawler->filter('.episodelist li')->each(function (Crawler $node) use (&$episodes) {
            $episodeTitle = $node->filter('a')->text();
            $episodeLink = $node->filter('a')->attr('href');

            $episodes[] = [
                'title' => trim($episodeTitle),
                'url' => $episodeLink
            ];
        });

        $animeDetail = [
            'title' => $title,
            'image' => $image,
            'synopsis' => $synopsis,
            'episodes' => $episodes, // Tambahkan daftar episode
            'endpoint' => $endpoint
        ];

        return view('anime_detail', compact('animeDetail'));
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal memuat detail anime.',
            'error_detail' => $e->getMessage()
        ], 500);
    }
}

public function watchAnime($endpoint)
{
    $url = "$this->baseUrl/anime/$endpoint/";

    try {
        $response = $this->client->get($url, [
            'headers' => ['User-Agent' => 'Mozilla/5.0'],
            'verify' => false
        ]);

        $html = $response->getBody()->getContents();
        \Log::info("HTML yang diterima: " . $html);  // Debug HTML yang diterima
        $crawler = new Crawler($html);

        // Coba ambil URL dari iframe (biasa digunakan untuk streaming)
        $videoUrl = $crawler->filter('iframe')->count() > 0 
            ? $crawler->filter('iframe')->attr('src') 
            : null;

        // Jika iframe tidak ditemukan, coba cari elemen video lainnya
        if (!$videoUrl) {
            $videoUrl = $crawler->filter('video source')->count() > 0 
                ? $crawler->filter('video source')->attr('src') 
                : null;
        }

        // Jika tetap tidak ditemukan, return error
        if (!$videoUrl) {
            return response()->json(['message' => 'Video tidak ditemukan, periksa struktur HTML situs sumber.'], 404);
        }

        return view('watch', compact('videoUrl', 'endpoint'));
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal memuat video anime.',
            'error_detail' => $e->getMessage()
        ], 500);
    }
}

    public function animeDetail($endpoint)
    {
        return $this->getAnimeDetail($endpoint);
    }

    public function getAnimeEpisode($endpoint, $episode)
    {
        return response()->json(['message' => "Episode $episode dari anime $endpoint belum diimplementasikan"]);
    }

    public function getAnimeVideo($endpoint)
    {
        return response()->json(['message' => "Video anime untuk $endpoint belum diimplementasikan"]);
    }

    public function downloadAnime($endpoint)
    {
        return response()->json(['message' => "Download anime untuk $endpoint belum diimplementasikan"]);
    }

    public function watchAnimeEpisode($anime, $episode)
{
    $url = "$this->baseUrl/anime/$anime/$episode/";

    try {
        $response = $this->client->get($url, [
            'headers' => ['User-Agent' => 'Mozilla/5.0'],
            'verify' => false
        ]);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $videoUrl = $crawler->filter('iframe')->count() > 0 
    ? $crawler->filter('iframe')->attr('src') 
    : ($crawler->filter('video source')->count() > 0 
        ? $crawler->filter('video source')->attr('src') 
        : null);


        if (!$videoUrl) {
            return response()->json(['message' => 'Video episode tidak ditemukan.'], 404);
        }

        return view('watch', compact('videoUrl', 'anime', 'episode'));
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal memuat video episode.',
            'error_detail' => $e->getMessage()
        ], 500);
    }
}



    public function animeEpisodeDetail($endpoint, $episode)
    {
        return response()->json(['message' => "Detail episode $episode dari anime $endpoint belum diimplementasikan"]);
    }

    public function showGenres()
{
    $ongoing = $this->getOngoingAnime();
    $completed = $this->getCompletedAnime();

    $genres = [];

    foreach (array_merge($ongoing, $completed) as $anime) {
        if (!empty($anime['genre'])) {
            $animeGenres = explode(',', $anime['genre']);
            foreach ($animeGenres as $g) {
                $genreName = trim($g);
                if (!empty($genreName) && !in_array($genreName, $genres)) {
                    $genres[] = $genreName;
                }
            }
        }
    }

    // Debugging: Jika genre kosong, cek hasilnya di terminal
    if (empty($genres)) {
        \Log::error("Tidak ada genre yang ditemukan!");
    }

    return view('genre_list', compact('genres'));
}

public function showByGenre($genre)
{
    $ongoing = $this->getOngoingAnime();
    $completed = $this->getCompletedAnime();

    $animeList = array_filter(array_merge($ongoing, $completed), function ($anime) use ($genre) {
        return stripos($anime['genre'], $genre) !== false;
    });

    return view('genre_detail', compact('animeList', 'genre'));

}

public function getVideoMirrors($endpoint)
{
    $url = "$this->baseUrl/anime/$endpoint/";

    try {
        $response = $this->client->get($url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0'
            ],
            'verify' => false
        ]);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $mirrors = [];

        // Cari elemen mirror dan resolusi
        $crawler->filter('.mirror_link')->each(function (Crawler $node) use (&$mirrors) {
            // Ambil resolusi
            $resolution = trim($node->filter('h4')->text() ?? '');
            if (!$resolution) return;  // Jika tidak ada resolusi, skip

            // Ambil link dan sumber mirror
            $node->filter('a')->each(function (Crawler $linkNode) use (&$mirrors, $resolution) {
                $source = trim($linkNode->text());
                $link = $linkNode->attr('href');

                if ($source && $link) {
                    $mirrors[$resolution][] = [
                        'source' => $source,
                        'link' => $link
                    ];
                }
            });
        });

        // Debugging: Tampilkan mirrors yang ditemukan
        \Log::info('Mirrors: ' . json_encode($mirrors));

        // Jika tidak ada mirrors, kirimkan pesan error
        if (empty($mirrors)) {
            return response()->json(['message' => 'Mirror tidak ditemukan.'], 404);
        }

        return response()->json(['mirrors' => $mirrors]);

    } catch (\Exception $e) {
        \Log::error('Error getVideoMirrors: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal memuat daftar mirror.',
            'error_detail' => $e->getMessage()
        ], 500);
    }
}




public function debugHtml($endpoint)
{
    $url = "$this->baseUrl/anime/$endpoint/";

    try {
        $response = $this->client->get($url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0'
            ],
            'verify' => false
        ]);

        return response($response->getBody()->getContents());
    } catch (\Exception $e) {
        return response("Gagal mengambil HTML: " . $e->getMessage(), 500);
    }
}


public function play($slug)
{
    $animeTitle = ucwords(str_replace('-', ' ', $slug));
    $videoUrl = "https://www.youtube.com/embed/dQw4w9WgXcQ";

    $mirrors = [
        "720p" => [
            ["source" => "Mirror 1", "link" => "https://www.youtube.com/embed/dQw4w9WgXcQ", "quality" => "720p"],
            ["source" => "Mirror 2", "link" => "https://www.youtube.com/embed/tgbNymZ7vqY", "quality" => "720p"]
        ],
        "1080p" => [
            ["source" => "Mirror 1", "link" => "https://www.youtube.com/embed/9bZkp7q19f0", "quality" => "1080p"]
        ]
    ];

    return view('anime.wacht', compact('animeTitle', 'videoUrl', 'mirrors'));
}


public function debugHtmlEpisode($anime, $episode)
{
    $url = "$this->baseUrl/anime/$anime/$episode/";

    try {
        $response = $this->client->get($url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0'
            ],
            'verify' => false
        ]);

        return response($response->getBody()->getContents());
    } catch (\Exception $e) {
        return response("Gagal mengambil HTML: " . $e->getMessage(), 500);
    }
}

public function getEpisodeMirrorsRaw($anime, $episode)
{
    $url = "$this->baseUrl/anime/$anime/episode/$episode/";

    $response = $this->client->get($url, ['verify' => false]);
    $html = $response->getBody()->getContents();
    $crawler = new Crawler($html);

    $mirrors = [];

    $crawler->filter('.mirror_link')->each(function (Crawler $node) use (&$mirrors) {
        $resolution = $node->filter('h4')->count() > 0 ? trim($node->filter('h4')->text()) : 'Unknown';

        $node->filter('a')->each(function (Crawler $aNode) use (&$mirrors, $resolution) {
            $source = trim($aNode->text());
            $link = $aNode->attr('href');

            if (!empty($link)) {
                $mirrors[$resolution][] = [
                    'source' => $source,
                    'link' => $link
                ];
            }
        });
    });

    return $mirrors;
}


public function showEpisode($anime, $episode)
{
    // Ambil mirrors
    $mirrors = $this->getEpisodeMirrorsRaw($anime, $episode); // versi raw, tidak pakai response()->json

    // Ambil title & link iframe
    $url = "$this->baseUrl/anime/$anime/episode/$episode/";
    $response = $this->client->get($url, ['verify' => false]);
    $html = $response->getBody()->getContents();
    $crawler = new Crawler($html);

    $title = $crawler->filter('title')->text() ?? 'Nonton Anime';
    $iframe = $crawler->filter('.responsive-embed iframe')->attr('src') ?? 'about:blank';

    return view('anime.episode', [
        'animeTitle' => $title,
        'videoUrl' => $iframe,
        'mirrors' => $mirrors
    ]);
}


}