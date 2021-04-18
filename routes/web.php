<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\TasaDolarController;
use App\Http\Controllers\DeudaController;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {    
    return view('index');
})->name('dashboard')->middleware('activeSession');

/**
 * Login
 */

Route::get('/login',[LoginController::class,'index'])->name('loginIndex');
Route::post('/login',[LoginController::class,'login'])->name('login');

/**
 * Logout
 */

Route::get('/logout', function (Request $request) {    
    if(session()->get('activeSession')){
        session()->flush();   
    }
    return redirect(route('loginIndex'));
})->name('logout')->middleware('activeSession');

/**
 * Deudas
 */

Route::get('/debt',[DeudaController::class,'display'])->name('deudas')->middleware('activeSession');
Route::get('/debt/add',[DeudaController::class,'addDebt'])->name('agregarDeuda')->middleware('activeSession');
Route::post('/debt/add',[DeudaController::class,'insertNewDebt'])->name('addNewDeuda')->middleware('activeSession');

/**
 * Tasa Dolar
 */
Route::get('/dolar',[TasaDolarController::class,'display'])->name('indexTasaDolar')->middleware('activeSession');
Route::get('/dolar/add',[TasaDolarController::class,'addRate'])->name('agregarTasaDolar')->middleware('activeSession');
Route::post('/dolar/add',[TasaDolarController::class,'insertNewRate'])->name('addNewTasaDolar')->middleware('activeSession');


/**
 * Testing
 */

Route::get('/testing', function (Request $request) {    
    return view('test');
});