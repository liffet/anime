<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class AnimeController extends Controller
{
    private $client;
    private $baseUrl = "https://otakudesu.best";

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

        $mirrors = [];

        // Ambil semua opsi download/stream yang ada (Otakudesu biasanya taruh di .download > ul > li)
        $crawler->filter('.download > ul > li')->each(function (Crawler $node) use (&$mirrors) {
            $resolution = $node->filter('strong')->count() > 0 ? trim($node->filter('strong')->text()) : 'Unknown';
            $servers = [];

            $node->filter('a')->each(function (Crawler $serverNode) use (&$servers) {
                $servers[] = [
                    'source' => trim($serverNode->text()),
                    'link'   => $serverNode->attr('href')
                ];
            });

            $mirrors[$resolution] = $servers;
        });

        // Ambil URL default untuk ditampilkan pertama kali
       $videoUrl = null;
foreach ($mirrors as $resolution => $servers) {
    foreach ($servers as $server) {
        if (!preg_match('/mega\.nz|drive\.google\.com|zippyshare\.com|mediafire\.com|acefile\.co/', $server['link'])) {
            $videoUrl = $server['link'];
            break 2; // keluar dari 2 loop
        }
    }
}


        return view('watch', [
            'animeTitle' => ucfirst(str_replace('-', ' ', $anime)),
            'videoUrl'   => $videoUrl,
            'mirrors'    => $mirrors,
            'episode'    => $episode
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal memuat video episode.',
            'error_detail' => $e->getMessage()
        ], 500);
    }
}



}