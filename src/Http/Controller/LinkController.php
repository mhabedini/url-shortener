<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Service\LinkShortenerService;
use Filimo\UrlShortener\Support\Http\Request;

class LinkController extends Controller
{
    public function store(Request $request)
    {
        return apiResponse(LinkShortenerService::store(...$request->all()), 201);
    }

    public function show(string $shortPath)
    {
        return apiResponse(LinkShortenerService::show($shortPath));
    }
}