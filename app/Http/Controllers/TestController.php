<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
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
                    ->join('shops', 'visits.shop_id', 'shops.id')
                    ->select('visits.*', 'shops.division_id as shop_division_id')
                    ->where('visits.user_id', '=', $user->id)
                    ->where('visits.shop_id', '=', $shop->id)
                    ->whereMonth('visits.created_at', '=', $month)
                    ->whereYear('visits.created_at', '=', $year)
                    ->where('shops.division_id', '=',  $user->division_id)
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

        $title = ''.Carbon::now()->format('F').', '.Carbon::now()->format('Y').'';

        $content = $pdf->download()->getOriginalContent();
        Storage::put('public/pdf/shop_visits_'.$title.'.pdf',$content);

        $file_link = url('/') . '/storage/pdf/shop_visits_'.$title.'.pdf';

        // return $pdf->download('Shop Visits.pdf');
        // $content = $pdf->download()->getOriginalContent();
        // Storage::put('public/pdf/shop_visits.pdf',$content);

        return view('bar-chart', compact('allData','date'));
    }
}
