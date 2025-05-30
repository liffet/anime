<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

// Route untuk halaman utama
Route::get('/', [AnimeController::class, 'index'])->name('home');

// Route untuk anime ongoing dan completed
Route::get('/anime/ongoing', [AnimeController::class, 'getOngoing'])->name('anime.ongoing');
Route::get('/anime/completed', [AnimeController::class, 'getCompleted'])->name('anime.completed');

// Route untuk detail anime
Route::get('/anime/{endpoint}', [AnimeController::class, 'getAnimeDetail'])->name('anime.detail');

// Route untuk video anime dan episode
Route::get('/anime/{endpoint}/video', [AnimeController::class, 'getAnimeVideo'])->name('anime.video');
Route::get('/anime/{endpoint}/watch', [AnimeController::class, 'watchAnime'])->name('anime.watch');
Route::get('/anime/{endpoint}/download', [AnimeController::class, 'downloadAnime'])->name('anime.download');

// Route untuk episode tertentu
Route::get('/anime/{endpoint}/episode/{episode}', [AnimeController::class, 'getAnimeEpisode'])->name('anime.episode');
Route::get('/anime/{endpoint}/episode/{episode}/video', [AnimeController::class, 'getAnimeVideo'])->name('anime.episode.video');
Route::get('/anime/{endpoint}/episode/{episode}/watch', [AnimeController::class, 'watchAnimeEpisode'])->name('anime.episode.watch');
Route::get('/anime/{endpoint}/episode/{episode}/download', [AnimeController::class, 'downloadAnime'])->name('anime.episode.download');
Route::get('/anime/{endpoint}/episode/{episode}/detail', [AnimeController::class, 'animeEpisodeDetail'])->name('anime.episode.detail');

// Route untuk genre anime
Route::get('/genre/{genre}', [AnimeController::class, 'showByGenre']);
Route::get('/genre', [AnimeController::class, 'showGenres'])->name('genre.list');

// Route untuk pencarian anime
Route::get('/search', [AnimeController::class, 'search']);

// Route untuk video mirrors dan download (route gabungan)
Route::get('/get-video-mirrors/{endpoint}/{episode?}/{mirror?}/{sub?}/{quality?}', [AnimeController::class, 'getVideoMirrors']);

// Route untuk debugging HTML
Route::get('/debug-html/{endpoint}', [AnimeController::class, 'debugHtml'])->middleware('local');

// Route untuk menampilkan anime berdasarkan ID
Route::get('/anime/{animeId}', [AnimeController::class, 'show'])->name('anime.show');
// routes/web.php


Route::get('/anime/{slug}/watch', [AnimeController::class, 'play'])->name('anime.watch');

Route::get('/anime/{endpoint}/debug-html', [AnimeController::class, 'debugHtml'])->name('anime.debug-html');
Route::get('/anime/{endpoint}', [AnimeController::class, 'getAnimeDetail'])->name('anime.detail');
Route::get('/anime/{endpoint}/video', [AnimeController::class, 'getAnimeVideo'])->name('anime.video');
Route::get('/anime/{endpoint}/episode/{episode}', [AnimeController::class, 'getAnimeEpisode'])->name('anime.episode');
Route::get('/anime/{endpoint}/episode/{episode}/video', [AnimeController::class, 'getAnimeVideo'])->name('anime.episode.video');
Route::get('/anime/{endpoint}/episode/{episode}/watch', [AnimeController::class, 'watchAnimeEpisode'])->name('anime.episode.watch');
Route::get('/anime/{endpoint}/episode/{episode}/download', [AnimeController::class, 'downloadAnime'])->name('anime.episode.download');              

Route::get('/anime/{anime}/episode/{episode}', [AnimeController::class, 'showEpisode']);
Route::get('/anime/{anime}/episode/{episode}/mirrors', [AnimeController::class, 'getEpisodeMirrors']);
