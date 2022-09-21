<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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


// anyone can register as a user
Route::apiResource('register', UserController::class)->only('store');

// get roles-list
Route::get('roles-list', [RolesController::class,'index']);

// anyone can try to login
Route::post('login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
// only login user can logout
Route::post('logout', [AuthController::class,'logout']);

// only registered users can access users data 
Route::apiResource('user', UserController::class);


// only users can access tikets data
Route::apiResource('ticket', TicketController::class);

// to see the available options for category, status, & priority level
Route::get('ticket-lookup', LookupController::class);

// to see the available options for category, status, & priority level
Route::apiResource('categories', CategoryController::class);

});


// guest can search ticket
Route::post('ticket/search',[PublicController::class,'search']);






