<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


class GenreController extends Controller
{

    private $client;
    private $baseUrl = "https://otakudesu.blog";


    public function __construct()
    {
        $this->client = new Client();
    }
    public function getGenres()
    {
        try {
            $url = "$this->baseUrl/genre-list/";

            $response = $this->client->get($url, [
                'headers' => ['User-Agent' => 'Mozilla/5.0'],
                'verify' => false
            ]);

            $html = $response->getBody()->getContents();
            $crawler = new Crawler($html);

            $genres = [];
            $crawler->filter('.genres li a')->each(function (Crawler $node) use (&$genres) {
                $href = trim($node->attr('href'));
                // Extract the slug by removing the base URL and '/genres/' prefix
                $slug = str_replace([$this->baseUrl . '/genres/', '/genres/', '/'], '', $href);
                $genres[] = [
                    'name' => trim($node->text()),
                    'slug' => $href, // Keep the full href if needed for other purposes
                    'endpoint' => $slug, // Clean slug, e.g., 'adventure'
                ];
            });

            // Selipkan 1 thumbnail contoh per genre, di-cache supaya tidak scraping ulang tiap request
            foreach ($genres as &$genre) {
                $genre['thumb'] = $this->getSampleThumbForGenre($genre['endpoint']);
            }
            unset($genre);

            return view('genre', compact('genres'));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memuat daftar genre.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ambil thumbnail anime pertama dari sebuah genre, untuk dipakai sebagai
     * gambar preview di tile genre. Di-cache per genre supaya tidak
     * scraping ulang setiap kali halaman /genre dibuka.
     */
    private function getSampleThumbForGenre(string $slug): ?string
    {
        return Cache::remember("genre-thumb:{$slug}", now()->addHours(12), function () use ($slug) {
            try {
                $response = $this->client->get($this->baseUrl . '/genres/' . $slug, [
                    'headers' => ['User-Agent' => 'Mozilla/5.0'],
                    'verify' => false,
                    'timeout' => 8,
                ]);

                $html = $response->getBody()->getContents();
                $crawler = new Crawler($html);

                $firstImg = $crawler->filter('.col-anime img')->first();

                return $firstImg->count() > 0 ? $firstImg->attr('src') : null;
            } catch (\Exception $e) {
                // Kalau gagal (timeout, genre kosong, dll), biarkan null.
                // Tile akan otomatis fallback ke warna gradient di Blade.
                return null;
            }
        });
    }

public function getAnimeByGenre(Request $request, $slug)
{
    try {
        $slug = trim($slug, '/');
        $page = $request->query('page', 1); // default ke page 1

        // kalau page > 1, urlnya jadi /genres/{slug}/page/{page}/
        $url = $this->baseUrl . '/genres/' . $slug;
        if ($page > 1) {
            $url .= '/page/' . $page . '/';
        }

        $response = $this->client->get($url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            ],
            'verify' => false
        ]);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $animeList = [];

        // ambil daftar anime di halaman ini
        $crawler->filter('.col-anime')->each(function ($node) use (&$animeList) {
            $title = $node->filter('.col-anime-title')->count() > 0 ? $node->filter('.col-anime-title')->text() : 'Unknown';
            $link = $node->filter('a')->count() > 0 ? $node->filter('a')->attr('href') : '';
            $thumb = $node->filter('img')->count() > 0 ? $node->filter('img')->attr('src') : '';
            $totalEpisode = $node->filter('.col-anime-eps')->count() > 0 ? $node->filter('.col-anime-eps')->text() : 'Unknown';

            $endpoint = str_replace([$this->baseUrl . '/anime/', '/'], '', $link);

            $animeList[] = [
                'title' => $title,
                'endpoint' => $endpoint,
                'thumb' => $thumb,
                'total_episode' => $totalEpisode
            ];
        });

        // cek apakah ada halaman berikutnya
        $hasNextPage = $crawler->filter('.pagination a.next')->count() > 0;

        $genreName = ucfirst($slug);

        return view('genre_detail', [
            'genreName'   => $genreName,
            'animeList'   => $animeList,
            'currentPage' => $page,
            'hasNextPage' => $hasNextPage
        ]);

    } catch (\Exception $e) {
        return view('error', [
            'message' => 'Gagal memuat anime berdasarkan genre.',
            'error_detail' => $e->getMessage()
        ]);
    }
}


}