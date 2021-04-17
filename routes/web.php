<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\TasaDolarController;
use App\Http\Controllers\DeudaController;


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
})->name('dashboard');

/**
 * Login
 */

 

/**
 * Deudas
 */

Route::get('/debt',[DeudaController::class,'display'])->name('deudas');
Route::get('/debt/add',[DeudaController::class,'addDebt'])->name('agregarDeuda');
Route::post('/debt/add',[DeudaController::class,'insertNewDebt'])->name('addNewDeuda');

/**
 * Tasa Dolar
 */
Route::get('/dolar',[TasaDolarController::class,'display'])->name('indexTasaDolar');
Route::get('/dolar/add',[TasaDolarController::class,'addRate'])->name('agregarTasaDolar');
Route::post('/dolar/add',[TasaDolarController::class,'insertNewRate'])->name('addNewTasaDolar');
