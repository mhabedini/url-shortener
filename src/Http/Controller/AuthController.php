<?php

namespace Filimo\UrlShortener\Http\Controller;

class AuthController extends Controller
{
    public function login()
    {
        $users = app()->queryBuilder('users')->all();
        return json_encode($users, JSON_THROW_ON_ERROR);
    }

    public function signup()
    {

    }
}