@extends('layouts/main-layout')

@section('style')
 
@endsection

@section('content')
<div class="col-lg-8 offset-lg-2 col-sm-12">
  <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div
          class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Agregar Tasa</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
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
                    <option value="{{$origin->id}}"
                      {{($origin->code == $selectedOrigin)?'selected':''}}
                      >{{$origin->name}}</option>
                @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Cargar</button>
          <a href="{{route('indexTasaDolar').'?origin='.$selectedOrigin}}" class="btn btn-secondary">Cancelar</a>
        </form>    
      </div>
  </div>
</div>
@endsection