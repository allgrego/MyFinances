<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/debt', function (Request $request) {
    return [];
});


Route::get('/dolar', function (Request $request) {    
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
        
        $tasaRate = ($tasa->rate+0.00);
        $tasaRate = number_format((float)$tasaRate,2,".","");
        //return $tasaRate;
        array_push($tasaDataset["rate"],$tasaRate);
    }

    foreach($tasaDataset["date"] as $key => $date){
        $auxTimestamp = explode(" ",$date);
        $auxDate = $auxTimestamp[0];
        $auxDate = explode("-", $auxDate);
        $auxDate = array_reverse($auxDate);
        $auxDate = implode("-",$auxDate);
        $auxTimestamp[0] = $auxDate;
        
        $tasaDataset['date'][$key] = implode(" ",$auxTimestamp);
    }

    // Cantidad de registros a mostrar
    $amount = $request->query('amount');
    // Mostrar los N últimos o primeros (order=first)
    $order = $request->query('order');

    if(is_numeric($amount)&&$amount>0){
        if($order=='first'){
            $tasaDataset["rate"] = array_slice($tasaDataset['rate'],0 ,$amount);
            $tasaDataset["date"] = array_slice($tasaDataset['date'],0 ,$amount);
        }else{
            $tasaDataset["rate"] = array_slice($tasaDataset['rate'],0-$amount,$amount);
            $tasaDataset["date"] = array_slice($tasaDataset['date'],0-$amount,$amount);
        }
    };

    $response = [
        "origin" => $originDolar,
        "data" => $tasaDataset["rate"],
        "labels" => $tasaDataset["date"]
    ];

    return json_encode($response);
    
})->name('api.dolar');

Route::get('/dolar/list', function (Request $request) {    
    // Id de Monitor
    $monitorQuery = DB::select('select id from dolar_origen where name=?',['Monitor Dolar']);
    $monitorId = $monitorQuery[0]->id;
    // Id de BCV
    $bcvQuery = DB::select('select id from dolar_origen where name=?',['BCV']);
    $bcvId = $bcvQuery[0]->id;

    $originDolar = $request->query('origin');

    if($originDolar=='bcv'){
        // Registro de Tasa
        $tasaDolar = DB::select('select id,rate,created_at from tasa_dolar where origin_id=? order by id desc',[$bcvId]);
        $originDolar = 'BCV';
    }else{
        // Registro de Tasa    
        $tasaDolar = DB::select('select id,rate,created_at from tasa_dolar where origin_id=? order by id desc',[$monitorId]);
        $originDolar = 'Monitor Dolar';
    }

    $counter = count($tasaDolar);
    $rowid = 0;

    foreach($tasaDolar as $tasa){
        $timestamp = $tasa->created_at;
        unset($tasa->created_at);
        $timestamp_aux = explode(" ",$timestamp);
        $tasa->date = $timestamp_aux[0];
        $tasa->time = $timestamp_aux[1];
        
        $date_aux = explode("-",$tasa->date);
        $date_aux = array_reverse($date_aux);
        $tasa->date = implode("-",$date_aux);

        $tasa->id = $counter;
        $tasa->rowid = $rowid;
        $counter--;
        $rowid++;
    }

    return json_encode([
        "list" => $tasaDolar
    ]);

})->name('api.chart.list');


