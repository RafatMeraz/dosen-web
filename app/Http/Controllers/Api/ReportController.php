<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    //
    public function index(Request $request)
    {
        $year = $request->year;
        // $yearStart = $year.'-01-01';
        // $yearEnd = $year.'-12-31';

        $month = $request->month;
        // $months = $year.'-'.$month;
        // return $monthEnd = $year.'-'.$month;

        $user = $request->user_id;

        $division_id = auth()->user()->division_id;
        $shops = DB::select("select id,name,address from shops where division_id = $division_id ");

        $list = [];
        foreach( $shops as $shop ) {
            $shop->counter = count(
                DB::table('visits')
                ->where('visits.user_id','=',$user)
                ->where('visits.shop_id','=',$shop->id)
                ->whereMonth('created_at','=',$month )
                ->whereYear('created_at', '=',$year)
                ->get());
            array_push($list, $shop);
        }

        // return $list;


        // $data = DB::table("users")
        // ->leftJoin('visits', 'visits.user_id', 'users.id')
        // ->leftJoin('divisions', 'divisions.id', 'users.division_id')
        // ->leftJoin('divisions', 'divisions.id', 'shops.division_id')
        // ->where('divisions.id' , $division_id)
        // // ->select('divisions.id')
        // ->select(
        //     'users.id as employee_id',
        //     'users.name as employee_name',
        //     'shops.id as shop_name',
        // //     'users.image as employee_image',
        // //     'users.designation as designation',
        // //     'users.role',
        // //     'users.phone',
        // //     'users.division_id',
        // //     'divisions.name as division_name',
        // //     'users.created_at as created_at',
        // //     'users.block as block',
        // //      DB::raw("count(visits.id) as total_visits"),
        // //      DB::raw("(
        // //             SELECT COUNT(visits.id) FROM visits
        // //             WHERE visits.user_id = users.id AND
        // //             visits.created_at >= '$monthStart .  00:00:00' AND visits.created_at <= '$monthEnd . 23:59:59' ) as last30daysVisits ")
        // )
        // // ->where('users.id', $user)
        // ->groupBy('users.id')
        // ->get();

         return response()->json([
             'success' => true,
             'data' => $list,
         ], 200);


    }
}
