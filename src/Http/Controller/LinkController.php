<?php

namespace Mhabedini\UrlShortener\Http\Controller;

use Exception;
use Mhabedini\UrlShortener\Exception\HttpException;
use Mhabedini\UrlShortener\Service\LinkShortenerService;
use Mhabedini\UrlShortener\Support\Http\Request;

class LinkController extends Controller
{
    /**
     * @throws HttpException
     * @throws Exception
     */
    public function store(Request $request): string
    {
        $userId = $this->authorize(true)['id'] ?? null;
        $link = LinkShortenerService::store($request->get('original_link'), $request->get('title'), $userId);
        return apiResponse($link, 201);
    }

    /**
     * @throws HttpException
     */
    public function show(string $shortPath): string
    {
        $link = LinkShortenerService::show($shortPath);
        if (!$link) {
            throw new HttpException('404 Not Found', 404);
        }
        return apiResponse($link);
    }
}