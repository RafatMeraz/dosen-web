<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function all_employees()
    {

        // $startDate = '2022-07-08';
        // $endDate = '2022-10-31';
        // $visits = count(DB::table('visits')
        //     ->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"])
        //     ->get());

        $startDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 month"));
        $endDate = date("Y-m-d");

         return response()->json([
             'success' => true,
             'data' => DB::table("users")
             ->leftJoin('visits', 'visits.user_id', 'users.id')
             ->leftJoin('divisions', 'divisions.id', 'users.division_id')
             ->select( 
                 'users.id as employee_id', 
                 'users.name as employee_name', 
                 'users.image as employee_image', 
                 'users.designation as designation',
                 'users.role',
                 'users.phone',
                 'users.division_id',
                 'divisions.name as division_name',
                 'users.created_at as created_at',
                 'users.block as block',
                 DB::raw("count(visits.id) as total_visits"),
                 DB::raw("(
                         SELECT COUNT(visits.id) FROM visits 
                         WHERE visits.user_id = users.id AND
                         visits.created_at >= '$startDate .  00:00:00' AND visits.created_at <= '$endDate . 23:59:59' ) as last30daysVisits ")
             )
             ->groupBy('users.id')
             ->paginate(25),
         ], 200);
    }



    public function employee($id)
    {
        $startDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 month"));
        $endDate = date("Y-m-d");
        
        $data = DB::table("users")
        ->leftJoin('visits', 'visits.user_id', 'users.id')
        ->leftJoin('divisions', 'divisions.id', 'users.division_id')
        ->select( 
            'users.id as employee_id', 
            'users.name as employee_name', 
            'users.image as employee_image', 
            'users.designation as designation',
            'users.role',
            'users.phone',
            'users.division_id',
            'divisions.name as division_name',
            'users.created_at as created_at',
            'users.block as block',
            DB::raw("count(visits.id) as total_visits"),
            DB::raw("(
                    SELECT COUNT(visits.id) FROM visits 
                    WHERE visits.user_id = users.id AND
                    visits.created_at >= '$startDate .  00:00:00' AND visits.created_at <= '$endDate . 23:59:59' ) as last30daysVisits ")
        )->where('users.id', $id)
        ->groupBy('users.id')
        ->get();

         return response()->json([
             'success' => true,
             'data' => $data,
         ], 200);
    }


    public function update(Request $request, $id)
    {
        try {
            User::where('id', $id)->update([
                'name'=> $request->name,
                'division_id'=> $request->division_id,
                'password'=> Hash::make($request->password),
             ]);
            return response()->json([
                'success' => true,
                'message' => 'Updated!',
            ], 200);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Update Failed!',
            ], 400);
        }
    }


    public function block($id)
    {
        try {
            $user = User::find($id);
            // dd($user);

            if($user->block == 1) {
                $user->block = 0;
            }else {
                $user->block = 1;
            }
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Blocked!',
            ], 200);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Block Failed!',
            ], 400);
        }
    }



    public function delete($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted!',
            ], 200);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Deleted Failed!',
            ], 400);
        }
    }

}
