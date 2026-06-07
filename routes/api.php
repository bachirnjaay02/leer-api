<?php

use App\Http\Controllers\XassidaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PlaylistController;
use Illuminate\Support\Facades\Route;

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

Route::get('/playlists',                      [PlaylistController::class, 'index']);
Route::get('/playlists/{id}',                 [PlaylistController::class, 'show']);
Route::post('/playlists',                     [PlaylistController::class, 'store']);
Route::delete('/playlists/{id}',              [PlaylistController::class, 'destroy']);
Route::post('/playlists/{id}/items',          [PlaylistController::class, 'addItem']);
Route::delete('/playlists/items/{itemId}',    [PlaylistController::class, 'removeItem']);
