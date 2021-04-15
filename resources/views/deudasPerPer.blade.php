@extends('layouts/main-layout')

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">Deudas Pendientes Por Persona</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
          <a href="{{route('deudas').'?mode=log'}}" class="btn btn-sm btn-outline-secondary">Log</a>
          <a href="{{route('deudas').'?mode=perperson'}}" class="btn btn-sm btn-outline-secondary">Por Persona</a>
        </div>
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
  </main>
@endsection