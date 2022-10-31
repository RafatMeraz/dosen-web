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
        $data = DB::table('users')
        ->select('users.id as employee_id',
            'users.name as employee_name',
            'users.designation as designation',)
        ->get();

         return response()->json([
             'success' => true,
             'data' => $data,
         ], 200);
    }



    public function employee($id)
    {
        return response()->json([
            'success' => true,
            'data' => User::findOrFail($id)
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
            $user->block = 1;
            $user->save();
            // User::find($id)->update(['block' === '1' ]);

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
