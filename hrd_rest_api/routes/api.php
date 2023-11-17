<?php

use App\Http\Controllers\ActiveEmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// membuat route pegawai

// menggrouping route
Route::middleware(['auth:sanctum'])->group(function () {
    // membuat method untuk get all pegawai
    Route::get('/employees', [EmployeeController::class,'index']);

    // membuat method untuk post pegawai  
    Route::post('/employees', [EmployeeController::class,'store']);

    // membuat method untuk put pegawai
    Route::put('/employees/{id}', [EmployeeController::class,'update']);

    // membuat method untuk delete pegawai
    Route::delete('/employees/{id}', [EmployeeController::class,'destroy']);
    
    // mendapatkan untuk detail pegawai 
    Route::get('/employees/{id}', [EmployeeController::class,'show']);

    // membuat route untuk search by name
    Route::get('/employees/search/{name}', [EmployeeController::class,'']);

    // membuat route active
    Route::get('employees/status/active', [EmployeeController::class, 'active'])->name('employees.active');

    //membuat route inactive 
    Route::get('employees/status/inactive', [EmployeeController::class, 'inactive'])->name('employees.inactive');

    // membuat route terminated
    Route::get('employees/status/terminated', [EmployeeController::class, 'terminated'])->name('employees.terminated');
});

// route untuk login dan register
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
