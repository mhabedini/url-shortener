<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Exception\HttpException;
use Filimo\UrlShortener\Service\AuthService;
use Filimo\UrlShortener\Support\Http\Request;

class AuthController extends Controller
{
    /**
     * @throws HttpException
     */
    public function login(Request $request): string
    {
        $token = AuthService::login($request);
        return apiResponse([
            'token' => $token,
        ]);
    }

    public function signup(Request $request): string
    {
        $user = AuthService::register($request);
        return apiResponse($user);
    }

}