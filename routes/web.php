<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('layouts.index');
});*/

Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('/importation', [PostController::class, 'importation'])->name('importer_fichiers');
Route::get('/constitution', [PostController::class, 'constitution'])->name('constituer_jury');
Route::get('/generation', [PostController::class, 'generation'])->name('generer_planning');
