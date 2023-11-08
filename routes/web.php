<?php

use App\Http\Controllers\AudiusMusicController;
use App\Http\Controllers\VideoGenerationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('tablero');
});
Route::post('/ruta-para/createClip', [VideoGenerationController::class, 'createClip'])->name('createClip')->middleware('web');
Route::post('/ruta-para/createClipSWH', [VideoGenerationController::class, 'createClipSWH'])->name('createClipSWH')->middleware('web');
Route::post('/webhook/d-id-clip', [VideoGenerationController::class, 'handleWebhook']);
Route::post('/search-and-download-music', [AudiusMusicController::class, 'searchAndDownloadMusic'])->name('createMusicSWH')->middleware('web');
