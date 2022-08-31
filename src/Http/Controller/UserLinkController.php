<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Exception\HttpException;
use Filimo\UrlShortener\Service\LinkShortenerService;
use Filimo\UrlShortener\Support\Database\DB;
use Filimo\UrlShortener\Support\Http\Request;

class UserLinkController extends Controller
{
    private array $user;

    public function __construct()
    {
        $this->user = $this->authorize(true);
    }

    public function index(): string
    {
        return apiResponse(LinkShortenerService::index($this->user['id']));
    }

    /**
     * @throws HttpException
     */
    public function update(int $linkId, Request $request): string
    {
        $this->checkUserOwnsLink($linkId);
        return apiResponse(LinkShortenerService::update($linkId, $request->all()));
    }

    /**
     * @throws HttpException
     */
    public function delete(int $linkId): string
    {
        $this->checkUserOwnsLink($linkId);
        return apiResponse(["success" => LinkShortenerService::delete($linkId)]);
    }

    /**
     * @throws HttpException
     */
    public function checkUserOwnsLink($linkId)
    {
        $link = DB::table('links')->find($linkId);
        if (!$link || $link['user_id'] != $this->user['id']) {
            throw new HttpException('No entry found', 404);
        }
    }
}