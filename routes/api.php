<?php

use Filimo\UrlShortener\Http\Controller\AuthController;
use Filimo\UrlShortener\Http\Controller\LinkController;
use Filimo\UrlShortener\Http\Controller\UserLinkController;
use Filimo\UrlShortener\Support\Http\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/signup', [AuthController::class, 'signup']);

Route::get('links/{shortPath}', [LinkController::class, 'show']);
Route::post('links', [LinkController::class, 'store']);

Route::get('user/links', [UserLinkController::class, 'index']);
Route::patch('user/links/{linkId}', [UserLinkController::class, 'update']);
Route::delete('user/links/{linkId}', [UserLinkController::class, 'delete']);