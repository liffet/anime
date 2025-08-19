<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [AnimeController::class, 'index'])->name('home');

// Genre routes
Route::get('/genre', [GenreController::class, 'getGenres'])->name('genre.list');
Route::get('/genre/{slug}', [GenreController::class, 'getAnimeByGenre'])->name('genre.show');

// Anime Listing
Route::prefix('anime')->group(function () {
    // Categories
    Route::get('/ongoing', [AnimeController::class, 'getOngoing'])->name('anime.ongoing');
    Route::get('/completed', [AnimeController::class, 'getCompleted'])->name('anime.completed');

    // Single anime detail
    Route::get('/{anime}', [AnimeController::class, 'getAnimeDetail'])->name('anime.detail');
    Route::get('/{anime}/watch', [AnimeController::class, 'watchAnime'])->name('anime.watch');
    Route::get('/{anime}/download', [AnimeController::class, 'downloadAnime'])->name('anime.download');
    Route::get('/{anime}/debug-html', [AnimeController::class, 'debugHtml'])->name('anime.debug.html');

    // Episode routes
    Route::prefix('{anime}/episode/{episode}')->group(function () {
        Route::get('/', [AnimeController::class, 'showEpisode'])->name('anime.episode.show');
        Route::get('/watch', [AnimeController::class, 'watchAnimeEpisode'])->name('anime.episode.watch');
        Route::get('/detail', [AnimeController::class, 'animeEpisodeDetail'])->name('anime.episode.detail');
        Route::get('/download', [AnimeController::class, 'downloadAnime'])->name('anime.episode.download');
        Route::get('/debug-html', [AnimeController::class, 'debugHtmlEpisode'])->name('anime.episode.debug.html');

        // Video mirrors
        Route::get('/mirrors', [AnimeController::class, 'getEpisodeMirrorsRaw'])->name('anime.episode.mirrors');
    });
});
