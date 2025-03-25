<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

Route::get('/', [AnimeController::class, 'index'])->name('home');

Route::get('/anime/ongoing', [AnimeController::class, 'getOngoing'])->name('anime.ongoing');
Route::get('/anime/completed', [AnimeController::class, 'getCompleted'])->name('anime.completed');

Route::get('/anime/{endpoint}', [AnimeController::class, 'getAnimeDetail'])->name('anime.detail');
Route::get('/anime/{endpoint}/video', [AnimeController::class, 'getAnimeVideo'])->name('anime.video');
Route::get('/anime/{endpoint}/watch', [AnimeController::class, 'watchAnime'])->name('anime.watch');
Route::get('/anime/{endpoint}/download', [AnimeController::class, 'downloadAnime'])->name('anime.download');

Route::get('/anime/{endpoint}/episode/{episode}', [AnimeController::class, 'getAnimeEpisode'])->name('anime.episode');
Route::get('/anime/{endpoint}/episode/{episode}/video', [AnimeController::class, 'getAnimeVideo'])->name('anime.episode.video');
Route::get('/anime/{endpoint}/episode/{episode}/watch', [AnimeController::class, 'watchAnimeEpisode'])->name('anime.episode.watch');
Route::get('/anime/{endpoint}/episode/{episode}/download', [AnimeController::class, 'downloadAnime'])->name('anime.episode.download');
Route::get('/anime/{endpoint}/episode/{episode}/detail', [AnimeController::class, 'animeEpisodeDetail'])->name('anime.episode.detail');

Route::get('/genre/{genre}', [AnimeController::class, 'showByGenre']);
Route::get('/genre', [AnimeController::class, 'showGenres'])->name('genre.list');

Route::get('/search', [AnimeController::class, 'search']);

