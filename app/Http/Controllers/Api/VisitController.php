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



    public function index()
    {
        // return 'uo';
        $data = DB::table("visits")
        ->join('shops', 'shops.id', 'visits.shop_id')
        ->select(
            'visits.id as id',
            'visits.remarks',
            'visits.created_at',
            'shops.id as shop_id',
            'shops.name as shop_name',
            'shops.address as shop_address',
        )
        ->orderBy('id', 'DESC')
        ->paginate(25);
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
            'visits.user_id as user_id',
            'users.name as user_name',
            'users.image as user_image',
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
                    'public/visits', Str::random(20).'.'.$request->file('image')->getClientOriginalExtension()
                );
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Visit image Failed!',
                ], 400);
            }
            $image = explode("public/",$image);
            try {
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
                    'message' => 'Visit Store Failed!',
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
                    'message' => 'User Registration Failed!', error($th->getMessage()),
                ], 400);
            }
        // }
    }



    public function option(Request $request)
    {
        // return $request->all();

        $startDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 month"));
        $endDate = date("Y-m-d");

        // Option year
        if ($request->has('year')) {
            return $request->all();
        }

        // Option month
        else if ($request->has('month')) {
            return $request->all();
        }

        // Option user_id
        else if ($request->has('user_id')) {
            return $request->all();
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
                'visits.user_id as user_id',
                'users.name as user_name',
                'users.image as user_image',
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
}
