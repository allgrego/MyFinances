<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    // Id de Monitor
    $monitorQuery = DB::select('select id from dolar_origen where name=?',['Monitor Dolar']);
    $monitorId = $monitorQuery[0]->id;
    // Id de BCV
    $bcvQuery = DB::select('select id from dolar_origen where name=?',['BCV']);
    $bcvId = $bcvQuery[0]->id;

    // Registro de Tasa
    $tasaDolarMonitor = DB::select('select id,rate,created_at from tasa_dolar where origin_id=?',[$monitorId]);
    $tasaDolarBCV = DB::select('select id,rate,created_at from tasa_dolar where origin_id=?',[$bcvId]);
    
    $originDolar = $request->query('origin');

    if($originDolar=='bcv'){
        $tasaDolar = $tasaDolarBCV;
        $originDolar = 'BCV';
    }else{
        $tasaDolar = $tasaDolarMonitor;
        $originDolar = 'Monitor Dolar';
    }
    // Data set    
    $tasaDataset = [
        "date" =>[],
        "rate" =>[]
    ];
    // Parse Dataset
    foreach($tasaDolar as $tasa){
        array_push($tasaDataset["date"],$tasa->created_at);
        array_push($tasaDataset["rate"],$tasa->rate);
    }
    
    // Date processing
    $counter = 1;
    foreach($tasaDolar as $tasa){
        $timestamp = $tasa->created_at;
        unset($tasa->created_at);
        $timestamp_aux = explode(" ",$timestamp);
        $tasa->date = $timestamp_aux[0];
        $tasa->time = $timestamp_aux[1];
        $tasa->id = $counter;
        $counter++;
    }
    
    return view('dashboard',[
        "tasaDolar" => $tasaDolar,
        "originDolar" => $originDolar,
        "tasaDataset" => $tasaDataset
    ]);
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
        return view('deudasPerPer',[
            "deudas_per_persona" => $deuda_per_persona,
            "pagada_per_persona" => $pagadas_per_persona
        ]);
    }else{
        return view('deudasLog',[
            "deudas" => $deudas,
            "deudas_pagadas" => $deudas_pagadas,
        ]);
    }
})->name('deudas');

Route::get('/tasaDolar', function (Request $request) {
    // Id de Monitor
    $monitorQuery = DB::select('select id from dolar_origen where name=?',['Monitor Dolar']);
    $monitorId = $monitorQuery[0]->id;
    // Id de BCV
    $bcvQuery = DB::select('select id from dolar_origen where name=?',['BCV']);
    $bcvId = $bcvQuery[0]->id;

    // Registro de Tasa
    $tasaDolarMonitor = DB::select('select id,rate,created_at from tasa_dolar where origin_id=?',[$monitorId]);
    $tasaDolarBCV = DB::select('select id,rate,created_at from tasa_dolar where origin_id=?',[$bcvId]);
    
    $originDolar = $request->query('origin');

    if($originDolar=='bcv'){
        $tasaDolar = $tasaDolarBCV;
        $originDolar = 'BCV';
    }else{
        $tasaDolar = $tasaDolarMonitor;
        $originDolar = 'Monitor Dolar';
    }
    // Data set    
    $tasaDataset = [
        "date" =>[],
        "rate" =>[]
    ];
    // Parse Dataset
    foreach($tasaDolar as $tasa){
        array_push($tasaDataset["date"],$tasa->created_at);
        array_push($tasaDataset["rate"],$tasa->rate);
    }
    
    // Date processing
    $counter = 1;
    foreach($tasaDolar as $tasa){
        $timestamp = $tasa->created_at;
        unset($tasa->created_at);
        $timestamp_aux = explode(" ",$timestamp);
        $tasa->date = $timestamp_aux[0];
        $tasa->time = $timestamp_aux[1];
        $tasa->id = $counter;
        $counter++;
    }
    
    return view('dashboard',[
        "tasaDolar" => $tasaDolar,
        "originDolar" => $originDolar,
        "tasaDataset" => $tasaDataset
    ]);
})->name('tasaDolar');