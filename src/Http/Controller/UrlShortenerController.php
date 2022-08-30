<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Service\LinkShortenerService;

class UrlShortenerController extends Controller
{
    public function show()
    {
        $link = LinkShortenerService::create('http://localhost:8000/api/login', 'title');
    }
}