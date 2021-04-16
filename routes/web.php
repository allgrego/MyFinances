<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\TasaDolarController;


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

Route::get('/deudas', function (Request $request) {
    // Deudas no pagadas
    $deudas = DB::select('select * from deuda where payed =?',[0]);

    // Deuda por persona
    $deuda_per_persona = [];

    foreach ($deudas as $deuda){
        if(empty($deuda_per_persona[$deuda->person])){
            $deuda_per_persona[$deuda->person] = [];
        }
        array_push($deuda_per_persona[$deuda->person],$deuda->amount);
    }

    foreach($deuda_per_persona as $persona => $montos){
        $total_persona = 0;
        foreach($montos as $monto){
            $total_persona += $monto;
        }
        $deuda_per_persona[$persona] = $total_persona;
    }
    
    // Deudas pagadas
    $deudas_pagadas = DB::select('select * from deuda where payed =?',[1]);

    // Deuda pagads por persona
    $pagadas_per_persona = [];

    foreach ($deudas_pagadas as $deuda){
        if(empty($pagadas_per_persona[$deuda->person])){
            $pagadas_per_persona[$deuda->person] = [];
        }
        array_push($pagadas_per_persona[$deuda->person],$deuda->amount);
    }

    foreach($pagadas_per_persona as $persona => $montos){
        $total_persona = 0;
        foreach($montos as $monto){
            $total_persona += $monto;
        }
        $pagadas_per_persona[$persona] = $total_persona;
    }

    if($request->query('mode')=='perperson'){
        return view('deudas/perPer',[
            "deudas_per_persona" => $deuda_per_persona,
            "pagada_per_persona" => $pagadas_per_persona
        ]);
    }else{
        return view('deudas/log',[
            "deudas" => $deudas,
            "deudas_pagadas" => $deudas_pagadas,
        ]);
    }
})->name('deudas');

/** Tasa Dolar **/
Route::get('/dolar',[TasaDolarController::class,'display'])->name('indexTasaDolar');
Route::get('/dolar/add',[TasaDolarController::class,'addRate'])->name('agregarTasaDolar');
Route::post('/dolar/add',[TasaDolarController::class,'insertNewRate'])->name('addNewTasaDolar');
