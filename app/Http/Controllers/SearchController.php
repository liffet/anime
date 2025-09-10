<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class SearchController extends Controller
{

     private $client;
        private $baseUrl = "https://otakudesu.best";

        public function __construct()
        {
            $this->client = new Client();
        }

public function search(Request $request)
{
    $keyword = $request->query('query');

    if (!$keyword) {
        return response()->json([
            'ongoing' => [],
            'completed' => []
        ]);
    }

    $url = $this->baseUrl . "/?s=" . urlencode($keyword) . "&post_type=anime";

    try {
        $response = $this->client->get($url, [
            'headers' => ['User-Agent' => 'Mozilla/5.0'],
            'verify' => false
        ]);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $results = [];
        
        // Coba beberapa selector yang mungkin digunakan oleh otakudesu
        $crawler->filter('.chivsrc, .page, .detpost, .animepost')->each(function (Crawler $node) use (&$results) {
            // Cari judul dengan beberapa kemungkinan selector
            $title = $node->filter('.tt, h2, .title, a')->first()->text('Unknown');
            
            // Cari gambar dengan beberapa kemungkinan selector
            $thumb = $node->filter('img')->count() ? $node->filter('img')->attr('src') : '';
            
            // Cari link
            $link = $node->filter('a')->count() ? $node->filter('a')->attr('href') : '';
            $endpoint = $link ? str_replace([$this->baseUrl . '/anime/', '/'], '', $link) : '';
            
            // Cari genre dan informasi lainnya
            $genre = $node->filter('.set, .genre, .info')->count() ? $node->filter('.set, .genre, .info')->text() : '';
            $total_episode = $node->filter('.epz, .episode, .eps')->count() ? $node->filter('.epz, .episode, .eps')->text() : 'N/A';
            
            // Deteksi status berdasarkan teks atau class tertentu
            $statusText = $node->filter('.bt, .status, .type')->count() ? $node->filter('.bt, .status, .type')->text() : '';
            $status = stripos($statusText, 'completed') !== false ? 'Completed' : 'Ongoing';

            $results[] = [
                'title' => trim($title),
                'thumb' => $thumb,
                'endpoint' => $endpoint,
                'genre' => trim($genre),
                'total_episode' => trim($total_episode),
                'status' => $status
            ];
        });

        // Jika tidak menemukan hasil dengan selector di atas, coba cara lain
        if (empty($results)) {
            $crawler->filter('article, .post')->each(function (Crawler $node) use (&$results) {
                if ($node->filter('h2')->count()) {
                    $title = $node->filter('h2')->text();
                    $thumb = $node->filter('img')->count() ? $node->filter('img')->attr('src') : '';
                    $link = $node->filter('a')->count() ? $node->filter('a')->attr('href') : '';
                    
                    $results[] = [
                        'title' => trim($title),
                        'thumb' => $thumb,
                        'endpoint' => $link ? basename($link) : '',
                        'genre' => '',
                        'total_episode' => 'N/A',
                        'status' => 'Ongoing'
                    ];
                }
            });
        }

        return response()->json([
            'ongoing' => array_values(array_filter($results, fn($anime) => $anime['status'] === 'Ongoing')),
            'completed' => array_values(array_filter($results, fn($anime) => $anime['status'] === 'Completed')),
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'ongoing' => [],
            'completed' => [],
            'error' => $e->getMessage()
        ]);
    }
}


}
