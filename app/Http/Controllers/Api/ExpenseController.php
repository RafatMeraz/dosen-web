<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    // public function index(Request $request)
    // {
    //     $year = $request->has('year') ? $request->year : date("Y");
    //     // $yearStart = $year.'-01-01';
    //     // $yearEnd = $year.'-12-31';

    //     $month = $request->has('month') ? $request->month : date("m");
    //     // $monthStart = $year.'-'.$month.'-01';
    //     // $monthEnd = $year.'-'.$month.'-31';

    //     if( auth()->user()->role == 'manager' )  // manager
    //     {  
    //         if ($request->has('user_id'))
    //         {
    //             if ($request->has('month')) 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereMonth('expenses.created_at','=',$month )
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //             if ($request->has('year')) 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereYear('expenses.created_at', '=',$year)
    //                 // ->whereMonth('created_at','=',$month )
    //                 // ->whereBetween('expenses.created_at', [ $yearStart . " 00:00:00"  , $yearEnd . " 23:59:59"])
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }  
    //             else 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //         }
    //         else if ($request->has('month')) 
    //         {
    //             if ($request->has('user_id'))
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereMonth('expenses.created_at','=',$month )
    //                 // ->whereYear('created_at', '=',$year)
    //                 // ->whereBetween('expenses.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //             else if ($request->has('year'))
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereYear('expenses.created_at', '=',$year)
    //                 // ->whereMonth('created_at','=',$month )
    //                 // ->whereBetween('expenses.created_at', [ $yearStart . " 00:00:00"  , $yearEnd . " 23:59:59"])
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //             else
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->whereMonth('expenses.created_at','=',$month )
    //                 // ->whereBetween('expenses.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
    //                 // ->whereYear('created_at', '=',$year)
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }  
    //         }
    //         else if ($request->has('year')) 
    //         {
    //             if ($request->has('user_id'))
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereYear('expenses.created_at', '=',$year)
    //                 // ->whereMonth('created_at','=',$month )
    //                 // ->whereBetween('expenses.created_at', [ $yearStart . " 00:00:00"  , $yearEnd . " 23:59:59"])
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //             if ($request->has('month')) 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->whereMonth('expenses.created_at','=',$month )
    //                 // ->whereBetween('expenses.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
    //                 // ->whereYear('created_at', '=',$year)
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //             else 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->whereYear('expenses.created_at', '=',$year)
    //                 // ->whereMonth('created_at','=',$month )
    //                 // ->whereBetween('expenses.created_at', [ $yearStart . " 00:00:00"  , $yearEnd . " 23:59:59"])
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //         }
    //         else 
    //         {
    //             $data = DB::table("expenses")
    //             ->join('users', 'users.id', 'expenses.user_id')
    //             ->select(
    //                 'expenses.id as expense_id',
    //                 'expenses.title as title',
    //                 'expenses.amount as amount',
    //                 'expenses.status as status',
    //                 'expenses.remarks as remarks',
    //                 'users.id as employee_id',
    //                 'users.name as employee_name',
    //                 'users.image as employee_image',
    //                 'expenses.created_at as date',
    //             )
    //             // ->groupBy('expenses.id')
    //             ->orderBy('expenses.id', 'DESC')
    //             ->paginate(25);
    //         }
    //     } 
    //     else   // user
    //     {
    //         $data = DB::table("expenses")
    //         ->join('users', 'users.id', 'expenses.user_id')
    //         ->where('expenses.user_id', auth()->id())
    //         ->select(
    //             'expenses.id as expense_id',
    //             'expenses.title as title',
    //             'expenses.amount as amount',
    //             'expenses.status as status',
    //             'expenses.remarks as remarks',
    //             'users.id as employee_id',
    //             'users.name as employee_name',
    //             'users.image as employee_image',
    //             'expenses.created_at as date',
    //         )
    //         // ->groupBy('expenses.id')
    //         ->orderBy('expenses.id', 'DESC')
    //         ->paginate(25);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $data,
    //     ], 200);
    // }

    // public function index(Request $request)
    // {
    //     if( auth()->user()->role == 'manager' )  // manager
    //     {  
    //         if ($request->has('year')) 
    //         {
    //             $year = $request->year;
    //             $yearStart = $year.'-01-01';
    //             $yearEnd = $year.'-12-31';

    //             if ($request->has('user_id')) 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereBetween('expenses.created_at', [ $yearStart, $yearEnd ])
    //                 ->select(
    //                         'expenses.id as expense_id',
    //                         'expenses.title as title',
    //                         'expenses.amount as amount',
    //                         'expenses.status as status',
    //                         'expenses.remarks as remarks',
    //                         'users.id as employee_id',
    //                         'users.name as employee_name',
    //                         'users.image as employee_image',
    //                         'expenses.created_at as date')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);

    //             } 
    //             if ($request->has('month')) 
    //             {
    //                 $month = $request->month;
    //                 $monthStart = $year.'-'.$month.'-01';
    //                 $monthEnd = $year.'-'.$month.'-31';

    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->whereBetween('expenses.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //             else {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->whereBetween('expenses.created_at', [ $yearStart, $yearEnd ])
    //                 ->select(
    //                         'expenses.id as expense_id',
    //                         'expenses.title as title',
    //                         'expenses.amount as amount',
    //                         'expenses.status as status',
    //                         'expenses.remarks as remarks',
    //                         'users.id as employee_id',
    //                         'users.name as employee_name',
    //                         'users.image as employee_image',
    //                         'expenses.created_at as date')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //         }

    //         else if ($request->has('month') ) 
    //         {
    //             $year = $request->has('year') ? $request->year : date("Y");
    //             $yearStart = $year.'-01-01';
    //             $yearEnd = $year.'-12-31';

    //             $month = $request->has('month') ? $request->month : date("m");
    //             $monthStart = $year.'-'.$month.'-01';
    //             $monthEnd = $year.'-'.$month.'-31';

    //             if ($request->has('user_id')) 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereBetween('expenses.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
    //                 ->select(
    //                         'expenses.id as expense_id',
    //                         'expenses.title as title',
    //                         'expenses.amount as amount',
    //                         'expenses.status as status',
    //                         'expenses.remarks as remarks',
    //                         'users.id as employee_id',
    //                         'users.name as employee_name',
    //                         'users.image as employee_image',
    //                         'expenses.created_at as date')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             } 
    //             else 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->whereBetween('expenses.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
    //                 ->select(
    //                         'expenses.id as expense_id',
    //                         'expenses.title as title',
    //                         'expenses.amount as amount',
    //                         'expenses.status as status',
    //                         'expenses.remarks as remarks',
    //                         'users.id as employee_id',
    //                         'users.name as employee_name',
    //                         'users.image as employee_image',
    //                         'expenses.created_at as date')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //         }

    //         else if ($request->has('user_id')) 
    //         {
    //             // return $request->all();
    //             if ($request->has('month') ) 
    //             {
    //                 $year = $request->has('year') ? $request->year : date("Y");
    //                 $yearStart = $year.'-01-01';
    //                 $yearEnd = $year.'-12-31';

    //                 $month = $request->has('month') ? $request->month : date("m");
    //                 $monthStart = $year.'-'.$month.'-01';
    //                 $monthEnd = $year.'-'.$month.'-31';
                
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereBetween('expenses.created_at', [ $monthStart . " 00:00:00"  , $monthEnd . " 23:59:59"])
    //                 ->select(
    //                         'expenses.id as expense_id',
    //                         'expenses.title as title',
    //                         'expenses.amount as amount',
    //                         'expenses.status as status',
    //                         'expenses.remarks as remarks',
    //                         'users.id as employee_id',
    //                         'users.name as employee_name',
    //                         'users.image as employee_image',
    //                         'expenses.created_at as date')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);

    //             }
    //             else if ($request->has('year')) 
    //             {
    //                 $year = $request->year;
    //                 $yearStart = $year.'-01-01';
    //                 $yearEnd = $year.'-12-31';
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->whereBetween('expenses.created_at', [ $yearStart, $yearEnd ])
    //                 ->select(
    //                         'expenses.id as expense_id',
    //                         'expenses.title as title',
    //                         'expenses.amount as amount',
    //                         'expenses.status as status',
    //                         'expenses.remarks as remarks',
    //                         'users.id as employee_id',
    //                         'users.name as employee_name',
    //                         'users.image as employee_image',
    //                         'expenses.created_at as date')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //             else 
    //             {
    //                 $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->where('expenses.user_id', $request->user_id)
    //                 ->select(
    //                         'expenses.id as expense_id',
    //                         'expenses.title as title',
    //                         'expenses.amount as amount',
    //                         'expenses.status as status',
    //                         'expenses.remarks as remarks',
    //                         'users.id as employee_id',
    //                         'users.name as employee_name',
    //                         'users.image as employee_image',
    //                         'expenses.created_at as date')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //             }
    //         }

    //         else 
    //         {
    //             $data = DB::table("expenses")
    //                 ->join('users', 'users.id', 'expenses.user_id')
    //                 ->select(
    //                     'expenses.id as expense_id',
    //                     'expenses.title as title',
    //                     'expenses.amount as amount',
    //                     'expenses.status as status',
    //                     'expenses.remarks as remarks',
    //                     'users.id as employee_id',
    //                     'users.name as employee_name',
    //                     'users.image as employee_image',
    //                     'expenses.created_at as date',
    //                 )
    //                 // ->groupBy('expenses.id')
    //                 ->orderBy('expenses.id', 'DESC')
    //                 ->paginate(25);
    //         }
    //     }
    //     else
    //     {
    //         $data = DB::table("expenses")
    //         ->join('users', 'users.id', 'expenses.user_id')
    //         ->where('expenses.user_id', auth()->id())
    //         ->select(
    //             'expenses.id as expense_id',
    //             'expenses.title as title',
    //             'expenses.amount as amount',
    //             'expenses.status as status',
    //             'expenses.remarks as remarks',
    //             'users.id as employee_id',
    //             'users.name as employee_name',
    //             'users.image as employee_image',
    //             'expenses.created_at as date',
    //         )
    //         // ->groupBy('expenses.id')
    //         ->orderBy('expenses.id', 'DESC')
    //         ->paginate(25);
    //     } 

    //     return response()->json([
    //         'success' => true,
    //         'data' => $data,
    //     ], 200);
       
    // }


    public function index(Request $request)
    {
        $user = $request->user_id;
        $year = $request->has('year') ? $request->year : date("Y");
        $month = $request->has('month') ? $request->month : date("m");

        if( auth()->user()->role == 'manager' )
        { 
            if ($request->has('user_id') || ($request->has('month')) || ($request->has('year')) ) 
            {
                $data = DB::table("expenses")
                ->join('users', 'users.id', 'expenses.user_id')
                ->where('expenses.user_id', $user)
                ->whereMonth('expenses.created_at','=',$month )
                ->whereYear('expenses.created_at', '=',$year)
                ->select(
                    'expenses.id as expense_id',
                    'expenses.title as title',
                    'expenses.amount as amount',
                    'expenses.status as status',
                    'expenses.remarks as remarks',
                    'users.id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'expenses.created_at as date',
                )
                ->orderBy('expenses.id', 'DESC')
                ->paginate(25);
            } else {
                $data = DB::table("expenses")
                ->join('users', 'users.id', 'expenses.user_id')
                ->select(
                    'expenses.id as expense_id',
                    'expenses.title as title',
                    'expenses.amount as amount',
                    'expenses.status as status',
                    'expenses.remarks as remarks',
                    'users.id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'expenses.created_at as date',
                )
                ->orderBy('expenses.id', 'DESC')
                ->paginate(25);
            }
        } 
        else 
        {
            $data = DB::table("expenses")
            ->join('users', 'users.id', 'expenses.user_id')
            ->where('expenses.user_id', auth()->id())
            ->select(
                'expenses.id as expense_id',
                'expenses.title as title',
                'expenses.amount as amount',
                'expenses.status as status',
                'expenses.remarks as remarks',
                'users.id as employee_id',
                'users.name as employee_name',
                'users.image as employee_image',
                'expenses.created_at as date',
            )
            // ->groupBy('expenses.id')
            ->orderBy('expenses.id', 'DESC')
            ->paginate(25);
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

















    public function store(Request $request)
    {

        // return $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
             return response()->json([
                'success' => false,
                'message' => $validator->messages()->first(),
            ], 400);
        }

            try {
                $expense = Expense::create([
                    'user_id'=> auth()->id(),
                    'title'=> $request->title,
                    'remarks'=> $request->remarks,
                    'amount'=> $request->amount,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Expense Store Succesfully!',
                    'data' => $expense
                ], 200);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Expense Store Failed!',
                ], 400);
            }
    }


    public function status(Request $request)
    {
        // return $expense_id = $request->id;
            try {
                Expense::where('id', $request->id)->update([
                    'status'=> $request->status
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Expense Update Succesfully!'
                ], 200);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Expense Update Failed!',
                ], 400);
            }
    }



    public function pendingList()
    {
        // return 'pending list';
        $data = DB::table("expenses")
                ->join('users', 'users.id', 'expenses.user_id')
                ->where('expenses.status','=', 'pending')
                ->select(
                    'expenses.id as expense_id',
                    'expenses.title as title',
                    'expenses.amount as amount',
                    'expenses.status as status',
                    'expenses.remarks as remarks',
                    'users.id as employee_id',
                    'users.name as employee_name',
                    'users.image as employee_image',
                    'expenses.created_at as date',
                )
                // ->groupBy('expenses.id')
                ->orderBy('expenses.id', 'DESC')
                ->paginate(25);
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function pendingCount()
    {
        // return 'pending count';
        $data = count(DB::table('expenses')
            ->where('expenses.status','=', 'pending')
            ->get());
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }
}
