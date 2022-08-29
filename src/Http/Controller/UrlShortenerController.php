<?php

namespace Filimo\UrlShortener\Http\Controller;

use JsonException;

class UrlShortenerController extends Controller
{
    /**
     * @throws JsonException
     */
    public function index(): bool|string
    {
        return json_encode([
            'hello' => 'world'
        ], JSON_THROW_ON_ERROR);
    }

    public function store()
    {
        return json_encode([
            'hello' => 'not world'
        ], JSON_THROW_ON_ERROR);

    }
}