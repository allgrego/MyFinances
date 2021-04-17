<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeudaController extends Controller
{
    public function display (Request $request) {
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

        // Según el modo redirecciona a log o total por persona
        if($request->query('mode')=='log'){
            return view('deudas/log',[
                "deudas" => $deudas,
                "deudas_pagadas" => $deudas_pagadas,
            ]);
        }else{
            return view('deudas/perPer',[
                "deudas_per_persona" => $deuda_per_persona,
                "pagada_per_persona" => $pagadas_per_persona
            ]);
        }
    }

    public function addDebt (Request $request) {
        
        return view('deudas/new');
    }

    public function insertNewDebt (Request $request) {
        $inputs =  $request->except('_token');

        if(empty($inputs)){
            return redirect(route('agregarDeuda').'?error=1');    
        }

        $inputs['debt-type'] = strtolower($inputs['debt-type']);

        $inputs['debt-amount'] = str_replace(",",".",$inputs['debt-amount']);

        DB::insert('insert into deuda (person, amount, type, reason) values (?, ?, ?, ?)', 
        [
            $inputs['debt-person'],
            $inputs['debt-amount'],
            $inputs['debt-type'],
            $inputs['debt-reason'],
        ]);

        return redirect(route('deudas'));
    }

}
