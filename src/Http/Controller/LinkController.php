<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Service\LinkShortenerService;
use Filimo\UrlShortener\Support\Http\Request;

class LinkController extends Controller
{
    public function store(Request $request)
    {
        $userId = null;
        $link = LinkShortenerService::store($request->get('original_link'), $request->get('title'), $userId);
        return apiResponse($link, 201);
    }

    public function show(string $shortPath)
    {
        $link = LinkShortenerService::show($shortPath);
        if (!$link) {
            throw new \Exception('404 Not Found');
        }
        return apiResponse($link);
    }
}