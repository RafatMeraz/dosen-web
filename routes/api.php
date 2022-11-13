<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
|   Author: Shajedul Hasan Arman - armanhassan504@gmail.com
|--------------------------------------------------------------------------
|   Laravel Framework 9.37.0
|   Composer version 2.4.4 2022-11
|   PHP 8.1.12
|   Auth Custom from Traversy media snactum auth api
*/

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::group(['middleware' => ['auth:sanctum','block']], function() {

    // User & Employee
    Route::get('/all_employees', [EmployeeController::class, 'all_employees']);
    Route::post('/employee/{id?}', [EmployeeController::class, 'employee']);
    Route::post('/employee/update/{id?}', [EmployeeController::class, 'update']);
    Route::post('/employee/block/{id?}', [EmployeeController::class, 'block']);
    Route::post('/employee/delete/{id?}', [EmployeeController::class, 'delete']);

    // Visits
    Route::get('/visits', [VisitController::class, 'index']);
    Route::post('/visit-detail/{id?}', [VisitController::class, 'detail']);
    Route::post('/visit-store', [VisitController::class, 'store']);
    Route::post('/visit-summary/{id?}', [VisitController::class, 'summary']);
    // Route::get('/visit-option', [VisitController::class, 'option']);

    //Division
    Route::get('/divisions', [DivisionController::class, 'index']);
    Route::post('/division-store', [DivisionController::class, 'store']);


    //Expense
    Route::get('/expense', [ExpenseController::class, 'index']);
    Route::post('/expense-store', [ExpenseController::class, 'store']);
    Route::post('/expense-status', [ExpenseController::class, 'status']);
    Route::get('/expense-pending-list', [ExpenseController::class, 'pendingList']);
    Route::get('/expense-pending-count', [ExpenseController::class, 'pendingCount']);

    //Shop
    Route::get('/shops', [ShopController::class, 'index']);
    Route::post('/shop-store', [ShopController::class, 'store']);


    //Report
    Route::get('/single-report', [ReportController::class, 'index']);
    // Route::post('/shop-store', [ReportController::class, 'store']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
  });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
