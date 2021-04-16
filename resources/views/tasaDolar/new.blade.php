@extends('layouts/main-layout')

@section('style')
 
@endsection

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">Agregar Tasa</h1>
    </div>   

    <div class="col-md-2 ml-sm-auto col-lg-6 align-items-center pl-4 pt-1 mb-4 border-left">
      <form method="post" action="{{route('addNewTasaDolar')}}">
        @csrf
        <div class="form-group">
          <label for="dolar-rate">Tasa (Bs/$)</label>
          <input type="number" class="form-control" name="dolar-rate" id="dolar-rate" aria-describedby="rateHelp" required
          min="0" step="0.01">
          <small id="rateHelp" class="form-text text-muted">Formato: "2123456,78" o "2123456,78"</small>
        </div>
        <div class="form-group">
          <label for="origin">Origen</label>
          <select name="origin" id="origin" class="form-control" required>
              @foreach ($dolarOrigins as $origin)
                  <option value="{{$origin->id}}">{{$origin->name}}</option>
              @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Cargar</button>
      </form>
    </div>
  </main>
@endsection