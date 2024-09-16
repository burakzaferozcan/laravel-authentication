<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CustomAuthController;
use \App\Http\Controllers\AuthorisationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/create-authorisation", [AuthorisationController::class, "index"]);
Route::get("/create-admin", [AuthorisationController::class, "createAdmin"]);


Route::get("/register", [CustomAuthController::class, 'create']);
Route::post("/register", [CustomAuthController::class, 'store']);

Route::get("/profile", [CustomAuthController::class, 'index']);

Route::get("/login", [CustomAuthController::class, 'login']);
Route::post("/login", [CustomAuthController::class, 'login']);
Route::get("/logout", [CustomAuthController::class, 'logout']);


