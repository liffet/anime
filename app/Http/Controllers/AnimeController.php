<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use GuzzleHttp\Client;
    use Symfony\Component\DomCrawler\Crawler;
    use Illuminate\Support\Str;

    class AnimeController extends Controller
    {
        private $client;
        private $baseUrl = "https://otakudesu.blog";

        public function __construct()
        {
            $this->client = new Client();
        }

       public function index(Request $request)
    {
        $ongoingPage = $request->query('ongoing_page', 1);
        $completedPage = $request->query('completed_page', 1);

        $ongoing = $this->fetchAnimeList("$this->baseUrl/ongoing-anime/", $ongoingPage);
        $completed = $this->fetchAnimeList("$this->baseUrl/complete-anime/", $completedPage);

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

private function fetchAnimeList($url, $page = 1)
{
    try {
        if ($page > 1) {
            $url .= "page/$page/";
        }

        $response = $this->client->get($url, [
            'headers' => ['User-Agent' => 'Mozilla/5.0'],
            'verify' => false
        ]);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $animeList = [];
        $crawler->filter('.venz > ul > li')->each(function (Crawler $node) use (&$animeList) {
            $genres = $node->filter('.set > a')->each(function (Crawler $genreNode) {
                return trim($genreNode->text());
            });

            $animeList[] = [
                'title' => $node->filter('h2')->count() > 0 ? trim($node->filter('h2')->text()) : 'Unknown',
                'thumb' => $node->filter('img')->count() > 0 ? $node->filter('img')->attr('src') : 'https://via.placeholder.com/200',
                'total_episode' => $node->filter('.epz')->count() > 0 ? trim($node->filter('.epz')->text()) : 'N/A',
                'endpoint' => $node->filter('a')->count() > 0 ? str_replace([$this->baseUrl . '/anime/', '/'], '', $node->filter('a')->attr('href')) : '',
                'genre' => !empty($genres) ? implode(', ', $genres) : '',
            ];
        });

        // Deteksi total halaman dari pagination
        $totalPages = 1;
        $pagination = $crawler->filter('.pagination a');
        if ($pagination->count() > 0) {
            $lastPageLink = $pagination->last()->attr('href');
            if (preg_match('/page\/(\d+)\//', $lastPageLink, $matches)) {
                $totalPages = (int)$matches[1];
            }
        }

        $hasNextPage = $crawler->filter('.pagination a.next')->count() > 0;

        return [
            'animeList' => $animeList,
            'hasNextPage' => $hasNextPage,
            'currentPage' => $page,
            'totalPages' => $totalPages // Tambahkan total halaman
        ];
    } catch (\Exception $e) {
        \Log::error("Error saat scraping: " . $e->getMessage());
        return [
            'animeList' => [],
            'hasNextPage' => false,
            'currentPage' => $page,
            'totalPages' => 1
        ];
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
                    'episodes' => $episodes,  
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

        



public function watchAnimeEpisode($anime, $episode)
{
    $url = "{$this->baseUrl}/anime/{$anime}/{$episode}/";

    try {
        $response = $this->client->get($url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'text/html,application/xhtml+xml',
            ],
            'timeout' => 20,
            'verify' => true,
        ]);

        $html = (string) $response->getBody();
        $crawler = new Crawler($html);


/*
 * STREAMING SOURCES
 * Prioritaskan video langsung daripada iframe.
 */
$streamSources = [];

// Fungsi untuk menormalkan URL.
$normalizeUrl = function ($link) {
    if (!$link) {
        return null;
    }

    $link = trim($link);

    if (str_starts_with($link, '//')) {
        $link = 'https:' . $link;
    } elseif (str_starts_with($link, '/')) {
        $link = $this->baseUrl . $link;
    }

    if (!filter_var($link, FILTER_VALIDATE_URL)) {
        return null;
    }

    if (!in_array(parse_url($link, PHP_URL_SCHEME), ['http', 'https'], true)) {
        return null;
    }

    return $link;
};

// 1. Cari video langsung terlebih dahulu.
$crawler->filter('video')->each(function (Crawler $node) use (&$streamSources, $normalizeUrl) {

    // Video dengan atribut src langsung.
    $link = $normalizeUrl($node->attr('src'));

    if ($link) {
        $streamSources[] = [
            'source' => parse_url($link, PHP_URL_HOST) ?: 'Video Server',
            'link' => $link,
            'type' => 'video',
        ];
    }

    // Video dengan tag source.
    $node->filter('source')->each(function (Crawler $sourceNode) use (&$streamSources, $normalizeUrl) {

        $link = $normalizeUrl($sourceNode->attr('src'));

        if ($link) {
            $streamSources[] = [
                'source' => parse_url($link, PHP_URL_HOST) ?: 'Video Server',
                'link' => $link,
                'type' => 'video',
            ];
        }
    });
});

// 2. Jika tidak ada video langsung, ambil iframe.
$crawler->filter('iframe')->each(function (Crawler $node) use (&$streamSources, $normalizeUrl) {

    $link = $normalizeUrl(
        $node->attr('src') ?: $node->attr('data-src')
    );

    if (!$link) {
        return;
    }

    $streamSources[] = [
        'source' => parse_url($link, PHP_URL_HOST) ?: 'Streaming Server',
        'link' => $link,
        'type' => 'iframe',
    ];
});

// 3. Hilangkan URL duplikat.
$streamSources = collect($streamSources)
    ->unique('link')
    ->values()
    ->all();

        /*
         * DOWNLOAD MIRRORS
         * Bagian ini tetap terpisah.
         */
        $mirrors = [];

        $crawler->filter('.download > ul > li')->each(
            function (Crawler $node) use (&$mirrors) {

                $resolution = $node->filter('strong')->count()
                    ? trim($node->filter('strong')->text())
                    : 'Unknown';

                $servers = [];

                $node->filter('a')->each(
                    function (Crawler $serverNode) use (&$servers) {

                        $link = $serverNode->attr('href');

                        if (!$link) {
                            return;
                        }

                        $servers[] = [
                            'source' => trim($serverNode->text()),
                            'link' => $link,
                        ];
                    }
                );

                if (count($servers)) {
                    $mirrors[$resolution] = $servers;
                }
            }
        );

        $cleanTitle = trim(preg_replace('/\s*sub\s*indo$/i', '', str_replace('-', ' ', $anime)));
        $q = urlencode($cleanTitle);

        $officialLinks = [
            ['name' => 'Crunchyroll',    'link' => "https://www.crunchyroll.com/search?q={$q}"],
            ['name' => 'Muse Indonesia', 'link' => "https://www.youtube.com/@MuseIndonesia/search?query={$q}"],
            ['name' => 'Bstation',       'link' => "https://www.bilibili.tv/id/search-result?q={$q}"],
        ];

        return view('watch', [
            'officialLinks' => $officialLinks,
            'animeTitle' => ucfirst($cleanTitle),
            'episode' => $episode,
            'streamSources' => $streamSources,
            'videoUrl' => $streamSources[0]['link'] ?? null,
            'videoType' => $streamSources[0]['type'] ?? null,
            'mirrors' => $mirrors,
        ]);

    } catch (\Throwable $e) {

        \Log::error('Watch anime error: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengambil data episode.',
            'error_detail' => config('app.debug') ? $e->getMessage() : null,
        ], 500);
    }
}



    }