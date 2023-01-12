<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Shop;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
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
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        $date = Carbon::now()->format('F, Y');

        $users = User::where('role', 'user')->get();

        $division_id = 1;
        $shops = Shop::select('id', 'name', 'address')->where('division_id', $division_id)->get();

        $allData = [];

        foreach ($users as $key => $user) {
            $dataSet = [];
            foreach ($shops as $shop) {
                $counter =  DB::table('visits')
                    ->where('visits.user_id', '=', $user->id)
                    ->where('visits.shop_id', '=', $shop->id)
                    ->whereMonth('created_at', '=', $month)
                    ->whereYear('created_at', '=', $year)
                    ->count();

                $dataSet[] = [
                    $shop->name,
                    $counter,
                ];
            }

            $allData[] = [
                'user' => $user,
                'dataSet' => $dataSet,
            ];
        }

        $pdf = PDF::loadView('bar-chart', compact('allData','date'));
        return $pdf->download('Shop Visits.pdf');

        // return view('bar-chart', compact('allData','date'));
    }
}
