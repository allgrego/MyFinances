<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasaDolarController extends Controller
{
    public function display (Request $request) {
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
        
        return view('tasaDolar/index',[
            "tasaDolar" => $tasaDolar,
            "originDolar" => $originDolar,
            "tasaDataset" => $tasaDataset
        ]);
    }

    public function addRate (Request $request) {
        $origins = DB::select('select * from dolar_origen where name !=?',['Otros']);        

        return view('tasaDolar/new',[
            "dolarOrigins" => $origins
        ]);
    }

    public function insertNewRate (Request $request) {
        $inputs =  $request->except('_token');

        if(empty($inputs)){
            return redirect(route('agregarTasaDolar').'?error=1');    
        }

        $inputs['dolar-rate'] = str_replace(",",".",$inputs['dolar-rate']);

        $origin = DB::select('select name from dolar_origen where id =?',[$inputs['origin']]);        

        if(!empty($origin)){
            $origin = $origin[0]->name;
            $origin = explode(" ",$origin);
            $origin = $origin[0];
            $origin = strtolower($origin);
        }        

        DB::insert('insert into tasa_dolar (id, rate,origin_id,created_at) values (?, ?, ?, ?)', 
        [
            null,
            $inputs['dolar-rate'],
            $inputs['origin'],
            null
        ]);

        return redirect(route('indexTasaDolar').'?origin='.$origin);
    }
}
