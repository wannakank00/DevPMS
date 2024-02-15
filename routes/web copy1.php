<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\PMSWelcomeController;
use App\Http\Controllers\EvaluateController;

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

// User
Route::get('/', function () {return view('UserLoginView');});

Route::post('/UserLogin', [UserLoginController::class, 'login'])->name('UserLogin');
Route::get('/UserLogin', [UserLoginController::class, 'login'])->name('UserLogin');

Route::get('/PMSWelcomeView', [PMSWelcomeController::class, 'PMS_Welcome'])->name('pms.welcome.get');
Route::post('/PMSWelcomeView', [PMSWelcomeController::class, 'PMS_Welcome'])->name('PMSWelcomeView');

Route::get('/PMSEvaluate', [EvaluateController::class, 'showPMSEvaluate'])->name('PMSEvaluate'); 

// Admin