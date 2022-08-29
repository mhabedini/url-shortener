<?php

use Filimo\UrlShortener\Http\Controller\UrlShortenerController;
use Filimo\UrlShortener\Support\Http\Route;

Route::get('hello', [UrlShortenerController::class, 'index']);
Route::post('hello', [UrlShortenerController::class, 'store']);