<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasaDolarController extends Controller
{
    public function display (Request $request) {
        
        $originDolar = $request->query('origin');
    
        if($originDolar=='bcv'){
            $originDolar = 'BCV';
        }else{
            $originDolar = 'Monitor Dolar';
        }
        
        return view('tasaDolar/index',[
            "originDolar" => $originDolar,
        ]);
    }

    public function addRate (Request $request) {
        $origins = DB::select('select id,name from dolar_origen where name !=?',['Otros']);        
        
        foreach($origins as $origin){
            $codeAux = $origin->name;
            $codeAux = explode(" ",$codeAux);
            $codeAux = $codeAux[0];
            $codeAux = strtolower($codeAux);
            $origin->code = $codeAux;
        }

        $selectedOrigin = $request->query('origin');

        // Si no es 'bcv' es 'monitor'
        if(strtolower($selectedOrigin)!='bcv'){
            $selectedOrigin = 'monitor';
        }

        return view('tasaDolar/new',[
            "dolarOrigins" => $origins,
            "selectedOrigin" => $selectedOrigin
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

        DB::insert('insert into tasa_dolar (rate,origin_id) values (?, ?)', 
        [
            $inputs['dolar-rate'],
            $inputs['origin'],
        ]);

        return redirect(route('indexTasaDolar').'?origin='.$origin);
    }
}
