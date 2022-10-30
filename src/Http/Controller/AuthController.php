<?php

namespace Mhabedini\UrlShortener\Http\Controller;

use Mhabedini\UrlShortener\Exception\HttpException;
use Mhabedini\UrlShortener\Service\AuthService;
use Mhabedini\UrlShortener\Support\Http\Request;

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