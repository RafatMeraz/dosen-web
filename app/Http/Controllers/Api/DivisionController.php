<?php

namespace App\Http\Controllers\Api;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;

class DivisionController extends Controller
{

    public function index()
    {

        // DB::select('select divisions.name,
        //     count(users.id) as totalEmployees from divisions
        //     join users on divisions.id = users.division_id
        //     group by divisions.name');

        $data = DB::table('divisions')
        ->leftJoin('users', 'users.division_id', 'divisions.id')
        ->select('divisions.id','divisions.name', DB::raw('count(users.id) as totalEmployee'))
        ->groupByRaw('divisions.id , divisions.name')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
        ]);

        try{
            $user = Division::create([
                'name' => $request->name,
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
}
