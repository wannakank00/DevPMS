<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PMSWelcomeController;
use App\Http\Controllers\AddOtherGoalsController;
use App\Http\Controllers\ShowRoundController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\AddEmployeeController;
use App\Http\Controllers\AddEmployeeInRoundController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\EditApproverController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserEvaluateController;
use App\Http\Controllers\EvaluateController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AddOtherGoals_1_Controller;


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

Route::get('/', function () {return view('UserLoginView');});

Route::get('/DashboardAdminView', function () {
    return view('DashboardAdminView');
});

Route::get('/pms_round', [ShowRoundController::class, 'index']);
Route::get('/ShowRound', [ShowRoundController::class, 'index'])->name('ShowRound');


Route::get('/AddRound', 'App\Http\Controllers\RoundController@showAddRoundView')->name('AddRound');
Route::post('/AddRound', 'App\Http\Controllers\RoundController@addRound')->name('SaveRound');

Route::get('/AddEmployee', [AddEmployeeController::class, 'addEmployeeForm'])->name('AddEmployee');
Route::post('/AddEmployee', [AddEmployeeController::class, 'uploadEmployeeData'])->name('AddEmployee');

Route::get('/AddEmployeeInRound', [AddEmployeeInRoundController::class, 'AddEmployeeInRoundForm'])->name('AddEmployeeInRound');
Route::post('/AddEmployeeInRound', [AddEmployeeInRoundController::class, 'SevaEmployeeInRoundData'])->name('AddEmployeeInRound');

Route::get('/edit-approver', [EditApproverController::class, 'editApprover'])->name('EditApprover');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/PMSWelcomeView', [PMSWelcomeController::class, 'PMS_Welcome'])->name('pms.welcome.get');
Route::post('/PMSWelcomeView', [PMSWelcomeController::class, 'PMS_Welcome'])->name('PMSWelcomeView');

// ตรวจสอบการกำหนดเส้นทาง GET
Route::get('/AddOtherGoals',[AddOtherGoalsController::class, 'OtherGoals'])->name('addothergoals.get');
Route::get('/welcome', 'PMSWelcomeController@index')->name('PMSWelcomeView');
// ตรวจสอบการกำหนดเส้นทาง POST
Route::post('/AddOtherGoals',[AddOtherGoalsController::class, 'OtherGoals'])->name('AddOtherGoals');

Route::post('/UserLogin', [UserLoginController::class, 'login'])->name('UserLogin');
Route::get('/UserLogin', [UserLoginController::class, 'login'])->name('UserLogin');

Route::get('/PMS_logout', [UserLoginController::class, 'logout'])->name('PMS_logout');
Route::post('/PMS_logout', [UserLoginController::class,'logout'])->name('PMS_logout');


Route::get('Evaluate', [EvaluateController::class, 'Evaluate'])->name('Evaluate');
Route::post('Evaluate',[EvaluateController::class,'Evaluate'])->name('Evaluate');
Route::get('EvaluateView', [EvaluateController::class, 'Evaluate'])->name('EvaluateView');
Route::post('EvaluateView',[EvaluateController::class,'Evaluate'])->name('EvaluateView');

Route::get('AddOtherGoals_1', [AddOtherGoals_1_Controller::class, 'AddOtherGoals'])->name('AddOtherGoals_1');
Route::post('AddOtherGoals_1',[AddOtherGoals_1_Controller::class,'AddOtherGoals'])->name('AddOtherGoals_1');


 // กลุ่มของ route ที่ต้องการให้เป็น admin เท่านั้น
