<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Service\LinkShortenerService;
use Filimo\UrlShortener\Support\Http\Request;

class UserLinkController extends Controller
{
    public function index()
    {
        return apiResponse(LinkShortenerService::index());
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