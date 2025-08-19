<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


class GenreController extends Controller
{

    private $client;
    private $baseUrl = "https://otakudesu.best";


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

            return view('genre', compact('genres'));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memuat daftar genre.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
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

