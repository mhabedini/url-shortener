<?php

namespace Filimo\UrlShortener\Http\Controller;

class UrlShortenerController extends Controller
{
    public function index()
    {
        return json_encode([
            'hello' => 'world'
        ], JSON_THROW_ON_ERROR);
    }
}