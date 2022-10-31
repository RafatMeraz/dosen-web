<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\VisitController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::group(['middleware' => ['auth:sanctum','block']], function() {

    // User
    Route::get('/all_employees', [EmployeeController::class, 'all_employees']);
    Route::post('/employee/{id?}', [EmployeeController::class, 'employee']);
    Route::post('/employee/update/{id?}', [EmployeeController::class, 'update']);
    Route::post('/employee/block/{id?}', [EmployeeController::class, 'block']);
    Route::post('/employee/delete/{id?}', [EmployeeController::class, 'delete']);



         //Store
    // Route::get('/visits', [VisitController::class, 'index']);
    Route::get('/visits', [VisitController::class, 'index']);
    Route::post('/visit-store', [VisitController::class, 'store']);





    //Division
    Route::get('/divisions', [DivisionController::class, 'index']);
    Route::post('/division-store', [DivisionController::class, 'store']);


    //Store
    Route::get('/shops', [ShopController::class, 'index']);
    Route::post('/shop-store', [ShopController::class, 'store']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
  });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
