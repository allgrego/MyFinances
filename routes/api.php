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

