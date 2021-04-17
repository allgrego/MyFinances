@extends('layouts/main-layout')

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">Deudas Pendientes</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">          
          <a href="{{route('deudas').'?mode=perperson'}}" class="btn btn-sm btn-outline-secondary">Por Persona</a>
          <a href="{{route('deudas').'?mode=log'}}" class="btn btn-sm btn-outline-primary">Log</a>
        </div>
        <a href="{{route('agregarDeuda')}}" class="btn btn-sm btn-outline-secondary">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
          Agregar Deuda
        </a>
      </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>            
            <th>Nombre</th>
            <th>Monto</th>
            <th>Razón</th>
            <th>Fecha</th>
          </thead>
          <tbody>
            @foreach ($deudas as $deuda)
                  <tr>
                    <td>{{$deuda->person}}</td>
                    <td>${{$deuda->amount}}</td>
                    <td>{{$deuda->reason}}</td>
                    <td>{{$deuda->created_at}}</td>
                  </tr>
              @endforeach
          </tbody>
        </table>
      </div>

    <h2>Deudas Pagadas</h2>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>            
            <th>Nombre</th>
            <th>Monto</th>
            <th>Razón</th>
            <th>Fecha</th>
          </thead>
          <tbody>
            @foreach ($deudas_pagadas as $deuda)
                  <tr>
                    <td>{{$deuda->person}}</td>
                    <td>${{$deuda->amount}}</td>
                    <td>{{$deuda->reason}}</td>
                    <td>{{$deuda->created_at}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
    </div>
  </main>
@endsection