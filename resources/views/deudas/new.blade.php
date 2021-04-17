@extends('layouts/main-layout')

@section('style')
 
@endsection

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">Agregar Nueva Deuda</h1>
    </div>   

    <div class="col-md-8 ml-sm-auto col-lg-6 align-items-center pl-4 pt-1 mb-4 border-left">
      <form method="post" action="{{route('addNewDeuda')}}">
        @csrf
        <div class="form-group col-lg-9 col-sm-12">
          <label for="debt-person">Acreedor</label>
          <input type="text" class="form-control" name="debt-person" id="debt-person" aria-describedby="personHelp" required>
          <small id="personHelp" class="form-text text-muted">Nombre de persona a quien le debe</small>
        </div>
        <div class="form-group col-lg-9 col-sm-12">
          <label for="debt-amount">Monto</label>
          <input type="number" class="form-control" name="debt-amount" id="debt-amount" aria-describedby="amountHelp" required
          min="0.01" step="0.01">
          <small id="amountHelp" class="form-text text-muted">Formato: "21", "21,00" o  "21.00"</small>
        </div>
        
        <div class="form-group col-lg-9 col-sm-12">
          <label for="debt-type">Tipo</label>
          <input type="text" class="form-control" name="debt-type" id="debt-type" aria-describedby="typeHelp" required>
          <small id="typeHelp" class="form-text text-muted">Opciones: cash, tdc, reserve, bs, etc.</small>
        </div>

        <div class="form-group col-lg-9 col-sm-12">
          <label for="debt-reason">Razón</label>
          <input type="text" class="form-control" name="debt-reason" id="debt-reason" aria-describedby="reasonHelp" required>
          <small id="reasonHelp" class="form-text text-muted">Ejemplo: "Compra de vegetales"</small>
        </div>
        <button type="submit" class="btn btn-primary">Cargar</button>
        <a href="{{route('deudas')}}" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </main>
@endsection