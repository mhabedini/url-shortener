<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Database\DB;
use Illuminate\Support\Collection;

class AuthController extends Controller
{
    public function login(): Collection
    {
        return DB::table('users')->all();
    }

    public function signup()
    {

    }
}