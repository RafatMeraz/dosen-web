<?php

namespace App\Http\Controllers\api;

use PDF;
use Exception;
use App\Models\Shop;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{
    public function chartPdf(Request $request)
    {
        try {
            $year = $request->year;
            $month = $request->month;
            $user = $request->user_id;

            $division_id = 1;
            $shops = Shop::select('id', 'name', 'address')->where('division_id', $division_id)->get();

            $dataSet = [["Shop", "Counter"]];

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
                    $counter,
                ];
            }

            return view('bar-chart', compact('dataSet'));

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    // public function downloadPdf(Request $request)
    // {
    //     $data = $request->get('htmlData');

    //     $pdf = PDF::loadView('pdf.chart', compact('data'));
    //     return $pdf->download('Shop Chart.pdf');
    // }
}
