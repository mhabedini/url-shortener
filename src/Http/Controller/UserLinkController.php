<?php

namespace Filimo\UrlShortener\Http\Controller;

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

    public function index()
    {
        return apiResponse(LinkShortenerService::index($this->user['id']));
    }

    public function update(int $linkId, Request $request)
    {
        $this->checkUserOwnsLink($linkId);
        return apiResponse(LinkShortenerService::update($linkId, $request->all()));
    }

    public function delete(int $linkId)
    {
        $this->checkUserOwnsLink($linkId);
        return apiResponse(["success" => LinkShortenerService::delete($linkId)]);
    }

    public function checkUserOwnsLink($linkId)
    {
        $link = DB::table('links')->find($linkId);
        if (!$link || $link['user_id'] != $this->user['id']) {
            throw new \Exception('No entry found', 404);
        }
    }
}