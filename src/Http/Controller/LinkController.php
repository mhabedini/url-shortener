<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Service\LinkShortenerService;
use Filimo\UrlShortener\Support\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        return apiResponse(LinkShortenerService::index());
    }

    public function store(Request $request)
    {
        return apiResponse(LinkShortenerService::store(...$request->all()), 201);
    }

    public function show(string $shortPath)
    {
        return apiResponse(LinkShortenerService::show($shortPath));
    }

    public function update(int $linkId, Request $request)
    {
        return apiResponse(LinkShortenerService::update($linkId, $request->all()));
    }

    public function delete(int $linkId)
    {
        return apiResponse(LinkShortenerService::delete($linkId));
    }
}