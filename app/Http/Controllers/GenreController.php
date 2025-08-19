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

    public function getAnimeByGenre($slug)
    {
        try {
            $slug = trim($slug, '/');
            $url = $this->baseUrl . '/genres/' . $slug;

            $response = $this->client->get($url, [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                ],
                'verify' => false
            ]);

            $html = $response->getBody()->getContents();
            $crawler = new Crawler($html);

            $animeList = [];
            $crawler->filter('.col-anime')->each(function ($node) use (&$animeList) {
                $title = $node->filter('.col-anime-title')->count() > 0 ? $node->filter('.col-anime-title')->text() : 'Unknown';
                $link = $node->filter('a')->count() > 0 ? $node->filter('a')->attr('href') : '';
                $thumb = $node->filter('img')->count() > 0 ? $node->filter('img')->attr('src') : '';
                $totalEpisode = $node->filter('.col-anime-eps')->count() > 0 ? $node->filter('.col-anime-eps')->text() : 'Unknown';

                // ambil endpoint dari URL Otakudesu, contoh: "https://otakudesu.best/anime/1piece-sub-indo/"
                $endpoint = str_replace([$this->baseUrl . '/anime/', '/'], '', $link);

                $animeList[] = [
                    'title' => $title,
                    'endpoint' => $endpoint, // ini yang dipakai di route lokal
                    'thumb' => $thumb,
                    'total_episode' => $totalEpisode
                ];
            });


            // Ambil nama genre untuk judul halaman
            $genreName = ucfirst($slug);

            // lempar data ke blade
            return view('genre_detail', compact('genreName', 'animeList'));

        } catch (\Exception $e) {
            return view('error', [
                'message' => 'Gagal memuat anime berdasarkan genre.',
                'error_detail' => $e->getMessage()
            ]);
        }
    }


}

