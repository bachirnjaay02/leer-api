<?php

use App\Http\Controllers\XassidaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\MagalVideoController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn() => response()->json(['status' => 'ok']));

Route::get('/xassidas',         [XassidaController::class, 'index']);
Route::post('/xassidas',        [XassidaController::class, 'store']);
Route::put('/xassidas/{id}',    [XassidaController::class, 'update']);
Route::delete('/xassidas/{id}', [XassidaController::class, 'destroy']);

Route::post('/pdfs',            [PdfController::class, 'upload']);
Route::delete('/pdfs/{id}',     [PdfController::class, 'destroy']);

Route::get('/settings/{key}',   [SettingController::class, 'show']);
Route::put('/settings/{key}',   [SettingController::class, 'update']);

Route::get('/push/vapid-key',       [NotificationController::class, 'vapidKey']);
Route::post('/push/subscribe',      [NotificationController::class, 'subscribe']);
Route::put('/push/prayer-times',    [NotificationController::class, 'updatePrayerTimes']);
Route::delete('/push/unsubscribe',  [NotificationController::class, 'unsubscribe']);
Route::post('/push/send',           [NotificationController::class, 'send']);

Route::get('/videos',         [VideoController::class, 'index']);
Route::post('/videos',        [VideoController::class, 'store']);
Route::delete('/videos/{id}', [VideoController::class, 'destroy']);

Route::get('/events',         [EventController::class, 'index']);
Route::get('/events/all',     [EventController::class, 'all']);
Route::post('/events',        [EventController::class, 'store']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);

Route::post('/audios',          [AudioController::class, 'upload']);
Route::delete('/audios/{id}',   [AudioController::class, 'destroy']);

Route::get('/playlists',                      [PlaylistController::class, 'index']);
Route::get('/playlists/{id}',                 [PlaylistController::class, 'show']);
Route::post('/playlists',                     [PlaylistController::class, 'store']);
Route::delete('/playlists/{id}',              [PlaylistController::class, 'destroy']);
Route::post('/playlists/{id}/items',          [PlaylistController::class, 'addItem']);
Route::delete('/playlists/items/{itemId}',    [PlaylistController::class, 'removeItem']);

Route::get('/magal-videos',         [MagalVideoController::class, 'index']);
Route::post('/magal-videos',        [MagalVideoController::class, 'store']);
Route::delete('/magal-videos/{id}', [MagalVideoController::class, 'destroy']);
