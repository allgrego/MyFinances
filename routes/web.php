<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $monitorQuery = DB::select('select id from dolar_origen where name=?',['Monitor Dolar']);
    $monitorId = $monitorQuery[0]->id;

    $bcvQuery = DB::select('select id from dolar_origen where name=?',['BCV']);
    $bcvId = $bcvQuery[0]->id;

    $tasaDolarMonitor = DB::select('select * from tasa_dolar where origin_id=?',[$monitorId]);
    $tasaDolarBCV = DB::select('select * from tasa_dolar where origin_id=?',[$bcvId]);

    $tasaDatasetMonitor = [
        "date" =>[],
        "rate" =>[]
    ];
    $tasaDatasetBCV = [
        "date" =>[],
        "rate" =>[]
    ];


    // Parse Monitor Dataset
    foreach($tasaDolarMonitor as $tasa){
        array_push($tasaDatasetMonitor["date"],$tasa->created_at);
        $tasa->rate += 0.0; 
        array_push($tasaDatasetMonitor["rate"],$tasa->rate);
    }
    // Parse BCV Dataset
    foreach($tasaDolarBCV as $tasa){
        array_push($tasaDatasetBCV["date"],$tasa->created_at);
        array_push($tasaDatasetBCV["rate"],$tasa->rate);
    }

    return view('dashboard',[
        "tasaDatasetMonitor" => $tasaDatasetMonitor
    ]);
});

Route::get('/deudas', function () {
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
        $deuda_per_persona[$persona] = '$'.$total_persona;
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
        $pagadas_per_persona[$persona] = '$'.$total_persona;
    }

    return view('index',[
        "deudas" => $deudas,
        "deudas_pagadas" => $deudas_pagadas,
        "deudas_per_persona" => $deuda_per_persona,
        "pagada_per_persona" => $pagadas_per_persona

    ]);
});