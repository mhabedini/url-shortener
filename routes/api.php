<?php

use Filimo\UrlShortener\Http\Controller\AuthController;
use Filimo\UrlShortener\Http\Controller\LinkController;
use Filimo\UrlShortener\Support\Http\Route;

Route::get('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'signup']);
Route::get('links/{shortPath}', [LinkController::class, 'show']);
Route::get('links', [LinkController::class, 'index']);
Route::post('links', [LinkController::class, 'store']);
Route::patch('links/{linkId}', [LinkController::class, 'update']);
Route::delete('links/{linkId}', [LinkController::class, 'delete']);