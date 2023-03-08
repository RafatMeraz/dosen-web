<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
class ShopController extends Controller
{
    public function index()
    {

        $user_id = auth()->id();
        $user = User::find($user_id);
        if ($user->role=='user')
        {
            $data = DB::table('shops')
                ->Join('divisions', 'divisions.id', 'shops.division_id')
                ->where('shops.division_id',$user->division_id)
                ->select('shops.id as shop_id',
                    'shops.name as shop_name',
                    'shops.address as shop_address',
                    'divisions.id as division_id',
                    'divisions.name as division_name')
                // ->select('shops.id', DB::raw('COUNT(*) as totalEmployee'))
                // ->groupBy('shops.id')
                ->get();
        }
        else
        {
        $data = DB::table('shops')
        ->Join('divisions', 'divisions.id', 'shops.division_id')
        ->select('shops.id as shop_id',
                'shops.name as shop_name',
                'shops.address as shop_address',
                'divisions.id as division_id',
                'divisions.name as division_name')
        // ->select('shops.id', DB::raw('COUNT(*) as totalEmployee'))
        // ->groupBy('shops.id')
        ->get();
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'division_id' => 'required',
            'address' => 'required',
        ]);

        try{
            $user = Shop::create([
                'name' => $request->name,
                'address' => $request->address,
                'division_id' => $request->division_id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Created Succesfull!'
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Created Failed!',
            ], 400);
        }
    }


    public function detail($id)
    {
        $data = Shop::where('id', $id)->first();
        $lastVisit = Visit::where('shop_id', $id)->latest()->first();
        $data->last_visit_time = date('D, d F Y h:i:s a', strtotime($lastVisit->created_at));
        //return response()->json($data);
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }


    public function delete($id)
    {
        try {
            $shop = Shop::find($id);
            $shop->delete();
            return response()->json([
                'success' => true,
                'message' => 'Shop Deleted!',
            ], 200);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Shop Deleted Failed!',
            ], 400);
        }
    }
}
