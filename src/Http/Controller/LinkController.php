<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Service\LinkShortenerService;

class LinkController extends Controller
{
    public function index()
    {
        return json(LinkShortenerService::index());
    }

    public function store(int $linkId, $request)
    {
        return json(LinkShortenerService::store($linkId, $request), 201);
    }

    public function show($shortPath)
    {
        return json(LinkShortenerService::show($shortPath));
    }

    public function update(int $linkId, $request)
    {
        return json(LinkShortenerService::update($linkId, $request));
    }

    public function delete(int $linkId)
    {
        return json(LinkShortenerService::delete($linkId));
    }
}