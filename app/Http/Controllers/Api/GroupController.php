<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request) {
        //return response()->json(json_decode($request->divisions));
        $group = new Group();
        $group->name = $request->get('name');
        $group->division_ids = $request->get('divisions');
        $group->created_by = auth()->id();
        $group->save();
        //return response()->json($group);
//        $group = Group::create([
//            'name'=> $request->name,
//            'division_ids'=> $request->divisions,
//            'created_by'=> auth()->id(),
//        ]);
        //$divisions = array_map('intval', $request->divisions);
        //return response()->json($divisions);
        return response()->json([
            'success' => true,
            'message' => 'Group Store Successfully!',
            'data' => $group
        ], 200);
    }

    public function list() {
        $groupList = Group::whereJsonContains('division_ids', (int) 2)->get();
        return response()->json($groupList);
    }
}
