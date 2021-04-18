@extends('layouts/main-layout')

@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Deudas Pendientes Por Persona</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
        <a href="{{route('deudas').'?mode=perperson'}}" class="btn btn-sm btn-outline-primary">Por Persona</a>
        <a href="{{route('deudas').'?mode=log'}}" class="btn btn-sm btn-outline-secondary">Log</a>
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
            <th>Monto Total Por Persona</th>
          </thead>
          <tbody>
            @foreach ($deudas_per_persona as $person => $total)
                  <tr>
                    <td>{{$person}}</td>
                    <td>${{$total}}</td>
                  </tr>
              @endforeach
          </tbody>
        </table>
      </div>

    <h2>Deudas Pagadas Por Persona</h2>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>            
          <th>Nombre</th>
          <th>Monto Total Por Persona</th>
        </thead>
          <tbody>
            @foreach ($pagada_per_persona as $person => $total)
                  <tr>
                    <td>{{$person}}</td>
                    <td>${{$total}}</td>
                  </tr>
            @endforeach
          </tbody>
      </table>
    </div>
@endsection