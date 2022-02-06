<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Models\Link;

use App\Models\Statistic;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;

class LinkController extends Controller
{

    /**
     * @param  LinkRequest  $request
     * @return Application|ResponseFactory|Response
     */
    public function create(LinkRequest $request)
    {
        $link = new Link();
        $link->link = $request->link;
        $link->save();

        return response(Link::DOMAIN.$link->short_link);
    }

    /**
     * @param  Request  $request
     * @param $shortLink
     * @return RedirectResponse
     * @throws Exception
     */
    public function get(Request $request, $shortLink)
    {
        $link = Link::where('short_link', $shortLink)->first();

        if ($link) {
            $agent = new Agent();
            $statistic = new Statistic();
            $statistic->device = $agent->platform();
            $statistic->browser = $agent->browser();
            $statistic->mobile = $agent->isiMobile();
            $statistic->ip = $request->getClientIp();
            $statistic->link()->associate($link);

            $statistic->save();

            return Redirect::away($link->link);
        } else {
            throw new Exception('Link is not exist', 422);
        }
    }
}
