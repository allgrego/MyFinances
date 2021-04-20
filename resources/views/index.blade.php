@extends('layouts/main-layout')

@section('style')
 <style>
    .second-series{
      background-color: 'transparent';
      border-color: '#007bff';
      border-width: 4;
      /* pointBackgroundColor: '#007bff'; */
    } 
  </style>    
@endsection

@section('content')
{{-- Page Heading --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-4 text-gray-800">Tablero</h1>  
</div>
<h5 class="h5 mb-4 pl-2 text-gray-600">¡Hola, Gregorio!</h5>  
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Tasa de Cambio ($)</div>
                      <a href="{{route('indexTasaDolar')}}"
                      class="btn btn-primary mb-0 font-weight-bold text-white-800">Ver Tasa</a>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-500"></i>
                  </div>
              </div>
          </div>
      </div>
    </div>
  <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                          Deudas</div>
                      <a
                      href="{{route('deudas')}}"
                       class="btn btn-danger mb-0 font-weight-bold text-white-800">Ir a Deudas</a>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-money-bill fa-2x text-gray-500"></i>
                  </div>
              </div>
          </div>
      </div>
    </div>

  </div>
@endsection