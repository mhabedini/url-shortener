<?php

use Mhabedini\UrlShortener\Http\Controller\AuthController;
use Mhabedini\UrlShortener\Http\Controller\LinkController;
use Mhabedini\UrlShortener\Http\Controller\UserLinkController;
use Mhabedini\UrlShortener\Support\Http\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/signup', [AuthController::class, 'signup']);

Route::get('links/{shortPath}', [LinkController::class, 'show']);
Route::post('links', [LinkController::class, 'store']);

Route::get('user/links', [UserLinkController::class, 'index']);
Route::patch('user/links/{linkId}', [UserLinkController::class, 'update']);
Route::delete('user/links/{linkId}', [UserLinkController::class, 'delete']);