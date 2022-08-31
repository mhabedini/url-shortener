<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Service\LinkShortenerService;
use Filimo\UrlShortener\Support\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        return json(LinkShortenerService::index());
    }

    public function store(Request $request)
    {
        return json(LinkShortenerService::store(...$request->all()), 201);
    }

    public function show(string $shortPath)
    {
        return json(LinkShortenerService::show($shortPath));
    }

    public function update(int $linkId, Request $request)
    {
        return json(LinkShortenerService::update($linkId, $request->all()));
    }

    public function delete(int $linkId)
    {
        return json(LinkShortenerService::delete($linkId));
    }
}