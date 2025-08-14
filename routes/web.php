<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

// Homepage
Route::get('/', [AnimeController::class, 'index'])->name('home');

// Genre routes - PERBAIKAN: Pindahkan ke atas sebelum anime routes

Route::get('/genre', [AnimeController::class, 'showGenres'])->name('genre.list');
Route::get('/genre/{genre}', [AnimeController::class, 'showByGenre'])->name('genre.detail');
// Debug route untuk testing genre scraping
Route::get('/debug/genre-scraping', [AnimeController::class, 'debugGenreScraping'])->name('debug.genre');



// Anime Listing
Route::prefix('anime')->group(function () {
    // Anime categories
    Route::get('/ongoing', [AnimeController::class, 'getOngoing'])->name('anime.ongoing');
    Route::get('/completed', [AnimeController::class, 'getCompleted'])->name('anime.completed');
    
    // Single anime routes
    Route::prefix('{anime}')->group(function () {
        // Main anime detail
        Route::get('/', [AnimeController::class, 'getAnimeDetail'])->name('anime.detail');
        
        // Watch/download main series
        Route::get('/watch', [AnimeController::class, 'watchAnime'])->name('anime.watch');
        Route::get('/download', [AnimeController::class, 'downloadAnime'])->name('anime.download');
        
        // Debugging
        Route::get('/debug-html', [AnimeController::class, 'debugHtml'])->name('anime.debug.html');
        
        // Episode routes
        Route::prefix('episode/{episode}')->group(function () {
            Route::get('/', [AnimeController::class, 'showEpisode'])->name('anime.episode.show');
            Route::get('/watch', [AnimeController::class, 'watchAnimeEpisode'])->name('anime.episode.watch');
            Route::get('/detail', [AnimeController::class, 'animeEpisodeDetail'])->name('anime.episode.detail');
            Route::get('/download', [AnimeController::class, 'downloadAnime'])->name('anime.episode.download');
            Route::get('/debug-html', [AnimeController::class, 'debugHtmlEpisode'])->name('anime.episode.debug.html');
            
            // Video mirrors
            Route::get('/mirrors', function ($anime, $episode) {
                return response()->json((new AnimeController())->getEpisodeMirrorsRaw($anime, $episode));
            })->name('anime.episode.mirrors');
        });
    });
});