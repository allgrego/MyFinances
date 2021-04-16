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

Route::get('/deudas', function (Request $request) {
    $origin = $request->query("origin");
    
    switch($origin){
        case 'bcv': {
            $bcvQuery = DB::select('select id from dolar_origen where name=?',['BCV']);
            $bcvId = $bcvQuery[0]->id;
            $tasaDolarBCV = DB::select('select * from tasa_dolar where origin_id=?',[$bcvId]);
            $tasaDatasetBCV = [
                "date" =>[],
                "rate" =>[]
            ];
            // Parse BCV Dataset
            foreach($tasaDolarBCV as $tasa){
                array_push($tasaDatasetBCV["date"],$tasa->created_at);
                array_push($tasaDatasetBCV["rate"],$tasa->rate);
            }
            return json_encode($tasaDatasetBCV);
        } break;
        default:{
            $monitorQuery = DB::select('select id from dolar_origen where name=?',['Monitor Dolar']);
            $monitorId = $monitorQuery[0]->id;

            $tasaDolarMonitor = DB::select('select * from tasa_dolar where origin_id=?',[$monitorId]);
            

            $tasaDatasetMonitor = [
                "date" =>[],
                "rate" =>[]
            ];
            // Parse Monitor Dataset
            foreach($tasaDolarMonitor as $tasa){
                array_push($tasaDatasetMonitor["date"],$tasa->created_at);
                $tasa->rate += 0.0; 
                array_push($tasaDatasetMonitor["rate"],$tasa->rate);
            }

            return json_encode($tasaDatasetMonitor);
        } break;
    }    
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
        array_push($tasaDataset["rate"],$tasa->rate);
    }


    $response = [
        "origin" => $originDolar,
        "data" => $tasaDataset["rate"],
        "labels" => $tasaDataset["date"]
    ];

    return json_encode($response);
    
})->name('api.chart');

