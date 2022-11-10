<?php

namespace App\Http\Controllers\Api;


use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{

    public function index(Request $request)
    {
        // Option year
        if ($request->has('year')) {
            // return $request->all();
            $year = $request->year;
            $yearStart = $year.'-01-01';
            $yearEnd = $year.'-12-31';
            // $today = date("Y-m-d"); // 2022-11-02 default
            // $startDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 year"));
            if ($request->has('user_id')) {
                $data = DB::table("visits")
                ->join('users', 'users.id', 'visits.user_id')
                ->join('shops', 'shops.id', 'visits.shop_id')
                ->whereBetween('visits.created_at', [ $yearStart, $yearEnd ])
                ->where('visits.user_id', $request->user_id)
                ->select(
                    'visits.id as visit_id',
                    'visits.remarks as remarks',
                    'visits.image as visit_image',
                    'visits.created_at as visit_dateTime',
                    'visits.user_id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                )
                ->groupBy('visits.id')
                ->orderBy('visits.id', 'DESC')
                ->paginate(25);
            } if ($request->has('month')) {
                $month = $request->month;
                $monthStart = $year.'-'.$month.'-01';
                $monthEnd = $year.'-'.$month.'-31';

                $data = DB::table("visits")
                ->join('users', 'users.id', 'visits.user_id')
                ->join('shops', 'shops.id', 'visits.shop_id')
                ->whereBetween('visits.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
                ->select(
                    'visits.id as visit_id',
                    'visits.remarks as remarks',
                    'visits.image as visit_image',
                    'visits.created_at as visit_dateTime',
                    'visits.user_id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                )
                ->groupBy('visits.id')
                ->orderBy('visits.id', 'DESC')
                ->paginate(25);
            }
            else {
                $data = DB::table("visits")
                ->join('users', 'users.id', 'visits.user_id')
                ->join('shops', 'shops.id', 'visits.shop_id')
                ->whereBetween('visits.created_at', [ $yearStart, $yearEnd ])
                ->select(
                    'visits.id as visit_id',
                    'visits.remarks as remarks',
                    'visits.image as visit_image',
                    'visits.created_at as visit_dateTime',
                    'visits.user_id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                )
                ->groupBy('visits.id')
                ->orderBy('visits.id', 'DESC')
                ->paginate(25);
            }
        }

        // Option month
        else if ($request->has('month') ) {
            // return $request->all();
            if (empty($request->year)) {
                $year = date("Y");
            }else {
                $year = $request->year;
            }
            $month = $request->month;
            $monthStart = $year.'-'.$month.'-01';
            $monthEnd = $year.'-'.$month.'-31';
            // $today = date("Y-m-d"); // 2022-11-02 default
            if ($request->has('user_id')) {
                $data = DB::table("visits")
                ->join('users', 'users.id', 'visits.user_id')
                ->join('shops', 'shops.id', 'visits.shop_id')
                ->where('visits.user_id', $request->user_id)
                ->whereBetween('visits.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
                ->select(
                    'visits.id as visit_id',
                    'visits.remarks as remarks',
                    'visits.image as visit_image',
                    'visits.created_at as visit_dateTime',
                    'visits.user_id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                )
                ->groupBy('visits.id')
                ->orderBy('visits.id', 'DESC')
                ->paginate(25);
            } else {
                $data = DB::table("visits")
                ->join('users', 'users.id', 'visits.user_id')
                ->join('shops', 'shops.id', 'visits.shop_id')
                ->whereBetween('visits.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
                ->select(
                    'visits.id as visit_id',
                    'visits.remarks as remarks',
                    'visits.image as visit_image',
                    'visits.created_at as visit_dateTime',
                    'visits.user_id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                )
                ->groupBy('visits.id')
                ->orderBy('visits.id', 'DESC')
                ->paginate(25);
            }
        }

        // Option user_id
        else if ($request->has('user_id')) {
            // return $request->all();
            if ($request->has('month') ) {
                if (empty($request->year)) {
                    $year = date("Y");
                }else {
                    $year = $request->year;
                }
                $month = $request->month;
                $monthStart = $year.'-'.$month.'-01';
                $monthEnd = $year.'-'.$month.'-31';
                $data = DB::table("visits")
                ->join('users', 'users.id', 'visits.user_id')
                ->join('shops', 'shops.id', 'visits.shop_id')
                ->where('visits.user_id', $request->user_id)
                ->whereBetween('visits.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
                ->select(
                    'visits.id as visit_id',
                    'visits.remarks as remarks',
                    'visits.image as visit_image',
                    'visits.created_at as visit_dateTime',
                    'visits.user_id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                )
                ->groupBy('visits.id')
                ->orderBy('visits.id', 'DESC')
                ->paginate(25);

            }
            else if ($request->has('year')) {
                $year = $request->year;
                $yearStart = $year.'-01-01';
                $yearEnd = $year.'-12-31';
                $data = DB::table("visits")
                ->join('users', 'users.id', 'visits.user_id')
                ->join('shops', 'shops.id', 'visits.shop_id')
                ->whereBetween('visits.created_at', [ $yearStart, $yearEnd ])
                ->where('visits.user_id', $request->user_id)
                ->select(
                    'visits.id as visit_id',
                    'visits.remarks as remarks',
                    'visits.image as visit_image',
                    'visits.created_at as visit_dateTime',
                    'visits.user_id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                )
                ->groupBy('visits.id')
                ->orderBy('visits.id', 'DESC')
                ->paginate(25);
            }
            else {
                $data = DB::table("visits")
                ->join('users', 'users.id', 'visits.user_id')
                ->join('shops', 'shops.id', 'visits.shop_id')
                ->where('visits.user_id', $request->user_id)
                ->select(
                    'visits.id as visit_id',
                    'visits.remarks as remarks',
                    'visits.image as visit_image',
                    'visits.created_at as visit_dateTime',
                    'visits.user_id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                )
                // ->groupBy('visits.id')
                ->orderBy('visits.id', 'DESC')
                ->paginate(25);
            }
        }

        // return 'All';
        else {
            $data = DB::table("visits")
            ->join('users', 'users.id', 'visits.user_id')
            ->join('shops', 'shops.id', 'visits.shop_id')
            ->select(
                'visits.id as visit_id',
                'visits.remarks as remarks',
                'visits.image as visit_image',
                'visits.created_at as visit_dateTime',
                'visits.user_id as employee_id',
                'users.name as employee_name',
                'users.image as employee_image',
                'shops.id as shop_id',
                'shops.name as shop_name',
                'shops.address as shop_address',
                // DB::raw("(
                //     SELECT COUNT(visits.id) FROM visits 
                //     WHERE visits.shop_id = shops.id 
                //     AND
                //     visits.created_at >= '$startDate .  00:00:00' AND visits.created_at <= '$endDate . 23:59:59' ) as thisShop_last30days_visits "),
            )
            // ->groupBy('visits.id')
            ->orderBy('visits.id', 'DESC')
            ->paginate(25);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
       
    }



    public function detail($id)
    {
        // return $id;
        $startDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 month"));
        $endDate = date("Y-m-d");

        $data = DB::table("visits")
        ->join('users', 'users.id', 'visits.user_id')
        ->join('shops', 'shops.id', 'visits.shop_id')
        ->where('visits.id', $id)
        ->select(
            'visits.id as visit_id',
            'visits.remarks as remarks',
            'visits.image as visit_image',
            'visits.created_at as visit_dateTime',
            'visits.user_id as employee_id',
            'users.name as employee_name',
            'users.image as employee_image',
            'shops.id as shop_id',
            'shops.name as shop_name',
            'shops.address as shop_address',
            DB::raw("(
                SELECT COUNT(visits.id) FROM visits 
                WHERE visits.shop_id = shops.id 
                AND
                visits.created_at >= '$startDate .  00:00:00' AND visits.created_at <= '$endDate . 23:59:59' ) as thisShop_last30days_visits "),
        )
        ->groupBy('visits.id')
        ->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }




    public function store(Request $request)
    {

        // return $request->all();

        $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
        ]);

        if ($validator->fails()) {
             return response()->json([
                'success' => false,
                'message' => $validator->messages()->first(),
            ], 400);
        }

        if ($request->hasFile('image'))
        {
            $image = '';
            try {
                $image = $request->file('image')->storeAs(
                    'public/visits', Str::random(5).'-'.time().'-'.Str::random(5).'.'.$request->file('image')->getClientOriginalExtension()
                );

                $image = explode("public/",$image);

                $visits = Visit::create([
                    'user_id'=> auth()->id(),
                    'shop_id'=> $request->shop_id,
                    'remarks'=> $request->remarks,
                    'image'=> $image[1]
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Visit Store Succesfully!',
                    'data' => $visits
                ], 200);

            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Visit image Failed!',
                ], 400);
            }
        }

            try {
                $visits = Visit::create([
                    'user_id'=> auth()->user()->id(),
                    'shop_id'=> $request->shop_id,
                    'remarks'=> $request->remarks,
                    'image'=> NULL
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Visit Store Succesfully!',
                    'data' => $visits
                ], 200);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Visit Store Failed!', error($th->getMessage()),
                ], 400);
            }
        // }
    }



    // public function option(Request $request)
    // {
    //     // Option year
    //     if ($request->has('year')) {
    //         // return $request->all();
    //         $startDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 year"));
    //         $today = date("Y-m-d");

    //         $data = DB::table("visits")
    //         ->join('users', 'users.id', 'visits.user_id')
    //         ->join('shops', 'shops.id', 'visits.shop_id')
    //         ->whereBetween('visits.created_at', [ $startDate . " 00:00:00"  , $today . " 23:59:59"])
    //         ->select(
    //             'visits.id as visit_id',
    //             'visits.remarks as remarks',
    //             'visits.image as visit_image',
    //             'visits.created_at as visit_dateTime',
    //             'visits.user_id as employee_id',
    //             'users.name as employee_name',
    //             'users.image as employee_image',
    //             'shops.id as shop_id',
    //             'shops.name as shop_name',
    //             'shops.address as shop_address',
    //         )
    //         ->groupBy('visits.id')
    //         ->orderBy('visits.id', 'DESC')
    //         ->paginate(25);
    //     }

    //     // Option month
    //     else if ($request->has('month') ) {
    //         // return $request->all();
    //         if (empty($request->year)) {
    //             $year = date("Y");
    //         }else {
    //             $year = $request->year;
    //         }
    //         $month = $request->month;
    //         $date = $year.'-'.$month.'-01';
    //         // $today = '2022-10-28';
    //         $today = date("Y-m-d"); // 2022-11-02 default

    //         $data = DB::table("visits")
    //         ->join('users', 'users.id', 'visits.user_id')
    //         ->join('shops', 'shops.id', 'visits.shop_id')
    //         ->whereBetween('visits.created_at', [ $date . " 00:00:00"  , $today . " 23:59:59"])
    //         ->select(
    //             'visits.id as visit_id',
    //             'visits.remarks as remarks',
    //             'visits.image as visit_image',
    //             'visits.created_at as visit_dateTime',
    //             'visits.user_id as employee_id',
    //             'users.name as employee_name',
    //             'users.image as employee_image',
    //             'shops.id as shop_id',
    //             'shops.name as shop_name',
    //             'shops.address as shop_address',
    //         )
    //         ->groupBy('visits.id')
    //         ->orderBy('visits.id', 'DESC')
    //         ->paginate(25);
    //     }

    //     // Option user_id
    //     else if ($request->has('user_id')) {
    //         // return $request->all();
    //         $data = DB::table("visits")
    //         ->join('users', 'users.id', 'visits.user_id')
    //         ->join('shops', 'shops.id', 'visits.shop_id')
    //         ->where('visits.user_id', $request->user_id)
    //         ->select(
    //             'visits.id as visit_id',
    //             'visits.remarks as remarks',
    //             'visits.image as visit_image',
    //             'visits.created_at as visit_dateTime',
    //             'visits.user_id as employee_id',
    //             'users.name as employee_name',
    //             'users.image as employee_image',
    //             'shops.id as shop_id',
    //             'shops.name as shop_name',
    //             'shops.address as shop_address',
    //         )
    //         // ->groupBy('visits.id')
    //         ->orderBy('visits.id', 'DESC')
    //         ->paginate(25);
    //     }

    //     // return 'All';
    //     else {
    //         $data = DB::table("visits")
    //         ->join('users', 'users.id', 'visits.user_id')
    //         ->join('shops', 'shops.id', 'visits.shop_id')
    //         ->select(
    //             'visits.id as visit_id',
    //             'visits.remarks as remarks',
    //             'visits.image as visit_image',
    //             'visits.created_at as visit_dateTime',
    //             'visits.user_id as employee_id',
    //             'users.name as employee_name',
    //             'users.image as employee_image',
    //             'shops.id as shop_id',
    //             'shops.name as shop_name',
    //             'shops.address as shop_address',
    //             // DB::raw("(
    //             //     SELECT COUNT(visits.id) FROM visits 
    //             //     WHERE visits.shop_id = shops.id 
    //             //     AND
    //             //     visits.created_at >= '$startDate .  00:00:00' AND visits.created_at <= '$endDate . 23:59:59' ) as thisShop_last30days_visits "),
    //         )
    //         // ->groupBy('visits.id')
    //         ->orderBy('visits.id', 'DESC')
    //         ->paginate(25);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $data,
    //     ], 200);
    // }




    public function summary($id = NULL)
    {

        // $todayDate = '2022-11-10' > $thisMonth = '2022-11-01'
        
        // $todayDate = '2022-11-10';
        $thisMonth = '2022-11-01';
        // return $id;
        $today = date("Y-m-d");
        // $today = date("Y-m-d")." 00:00:00" ;
        // $todayDate = date("d");
        // $thisMonth = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-$todayDate day"));

        // $startDate = date("Y-m-d");
        // return $thisMonth = $today - $startDate;

        // $monthStart = $year.'-'.$month.'-01';
        // $monthEnd = $year.'-'.$month.'-31';

        if( auth()->user()->role == 'manager' ) {
            // return 'manager';
            $data = DB::table("visits")
            ->join('users', 'users.id', 'visits.user_id')
            // ->join('shops', 'shops.id', 'visits.shop_id')
            // ->where('visits.id', $id)
            ->select( 
                // 'visits.id as visit_id',
                DB::raw("(
                    SELECT COUNT(visits.id) FROM visits 
                    WHERE
                    visits.created_at >= '$thisMonth  . 00:00:00' AND visits.created_at <=  '$today . 23:59:59')
                    as monthAllEmployeeVisits " 
                ),
                DB::raw("(
                    SELECT COUNT(visits.id) FROM visits 
                    WHERE
                    visits.created_at >= '$today')
                    as todayAllEmployeeVisits " 
                ),
            )
            // ->groupBy('visits.id')
            // ->groupBy('visits.user_id')
            // ->groupBy('users.id')
            ->take(1)
            ->get();

        } else {
            // return 'not manager';
            $id = auth()->id();
            return $data = DB::table("visits")
            ->join('users', 'users.id', 'visits.user_id')
            // ->join('shops', 'shops.id', 'visits.shop_id')
            // ->where('visits.user_id', auth()->id())
            ->select( 
                // 'visits.id as visit_id',
                DB::raw("(
                    SELECT COUNT(visits.id) FROM visits 
                    WHERE
                    visits.user_id = $id
                    AND
                    visits.created_at >= '$thisMonth  . 00:00:00' 
                    AND 
                    visits.created_at <=  '$today . 23:59:59' )
                    as monthVisits " 
                ),
                DB::raw("(
                    SELECT COUNT(visits.id) FROM visits 
                    WHERE
                    visits.user_id = $id
                    AND
                    visits.created_at >= '$today')
                    as todayVisits " 
                ),
            )
            // ->groupBy('visits.id')
            // ->groupBy('visits.user_id')
            ->groupBy('users.id')
            // ->take(1)
            ->get();
        }
    
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }
}








// public function index()
// {
//     // return 'uo';
//     $data = DB::table("visits")
//     ->join('shops', 'shops.id', 'visits.shop_id')
//     ->select(
//         'visits.id as id',
//         'visits.remarks',
//         'visits.created_at',
//         'shops.id as shop_id',
//         'shops.name as shop_name',
//         'shops.address as shop_address',
//     )
//     ->orderBy('id', 'DESC')
//     ->paginate(25);
//      return response()->json([
//          'success' => true,
//          'data' => $data,
//      ], 200);
// }