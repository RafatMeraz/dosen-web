<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Shop;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function pdf(Request $request)
    {
        $year = 2022;
        $month = 12;
        $user = 1;

        $division_id = 1;
        $shops = Shop::select('id', 'name', 'address')->where('division_id', $division_id)->get();

        $dataSet = [];

        foreach ($shops as $shop) {
            $counter =  DB::table('visits')
                ->where('visits.user_id', '=', $user)
                ->where('visits.shop_id', '=', $shop->id)
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->count();

            $dataSet[] = [
                $shop->name,
                $counter,
            ];
        }

        return view('bar-chart', compact('dataSet'));
    }
}
