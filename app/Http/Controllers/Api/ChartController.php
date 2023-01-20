<?php

namespace App\Http\Controllers\Api;

use PDF;
use Exception;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;

class ChartController extends Controller
{
    public function chartPdf(Request $request)
    {
        try {
            $year = $request->year;
            $month = $request->month;
            $user = $request->user_id;

            $division_id = 1;
            $getUser = User::find($user);

            $shops = Shop::select('id', 'name', 'address')->where('division_id', $getUser->division_id)->get();

            // dd($getUser);

            $dataSet = [];

            foreach ($shops as $shop) {
                $counter =  DB::table('visits')
                    ->join('shops', 'visits.shop_id', 'shops.id')
                    ->select('visits.*', 'shops.division_id as shop_division_id')
                    ->where('visits.user_id', $user)
                    ->where('visits.shop_id', $shop->id)
                    ->whereMonth('visits.created_at', $month)
                    ->whereYear('visits.created_at', $year)
                    ->where('shops.division_id', '=',  $getUser->division_id)
                    ->count();

                $dataSet[] = [
                    $shop->name,
                    $counter,
                ];
            }

            $pdf = PDF::loadView('pdf.chart', compact('dataSet'));
            return $pdf->download('Shop Chart.pdf');

            // return view('bar-chart', compact('dataSet'));

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
