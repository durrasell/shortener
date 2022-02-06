<?php

namespace App\Http\Controllers;


use App\Http\Requests\StatisticRequest;
use App\Models\Statistic;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{

    public function statistics(StatisticRequest $request)
    {
        $statistic = Statistic::query();

        if (!$request->only(['device', 'browser', 'desktop', 'mobile'])) {
            $statistic->select(
                DB::raw('COUNT(device) as device'),
                DB::raw('COUNT(browser) as browser'),
                DB::raw('COUNT(IF(mobile = 1, mobile, NULL)) as mobile'),
                DB::raw('COUNT(IF(mobile = 0, mobile, NULL)) as desktop')
            );

            return response()->json($statistic->get());
        }

        if ($request->device) {
            $statistic->select('device',
                DB::raw('COUNT(browser) as browser'),
                DB::raw('COUNT(IF(mobile = 1, mobile, NULL)) as mobile'),
                DB::raw('COUNT(IF(mobile = 0, mobile, NULL)) as desktop')
            );
            $statistic->groupBy('device');
        }

        if ($request->browser) {
            $statistic->select('browser',
                DB::raw('COUNT(device) as device'),
                DB::raw('COUNT(IF(mobile = 1, mobile, NULL)) as mobile'),
                DB::raw('COUNT(IF(mobile = 0, mobile, NULL)) as desktop')
            );
            $statistic->groupBy('browser');
        }

        if ($request->mobile || $request->desktop) {
            $statistic->select('mobile',
                DB::raw('COUNT(device) as device'),
                DB::raw('COUNT(browser) as browser')
            );
            $statistic->groupBy('mobile');
        }

        return response()->json($statistic->get());
    }
}
