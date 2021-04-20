@extends('layouts/login-layout')

@section('form')

<div class="text-center">
  <h1 class="h4 text-gray-900 mb-4">MyFinances</h1>
  <h3 class="h4 text-700 mb-4">Bienvenido de vuelta!</h3>
</div>
<form class="user" method="post" action="{{route('login')}}">
  @csrf
  <div class="form-group">
      <input type="text" class="form-control form-control-user"
          name="username" id="inputUsername"
          aria-describedby="usernameHelp"
          required
          placeholder="Enter Username...">
  </div>
  <div class="form-group">
      <input type="password" class="form-control form-control-user"
        name="password" required
        id="inputPassword" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary btn-user btn-block">
      Iniciar Sesión
  </button>
  <hr>
</form>
<hr>
<div class="text-center">
  <a class="small" href="#">¿Olvidaste tu Contraseña?</a>
</div>
{{-- <div class="text-center">
  <a class="small" href="#">Crear una Cuenta!</a>
</div> --}}

{{-- <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">MyFinances</h1>
    </div>   

    <div class="col-md-8 ml-sm-auto col-lg-6 align-items-center pl-1 pt-1 mb-4 border-left">
        <h2 class="h2">Iniciar Sesión</h2>
      <form method="post" action="{{route('login')}}">
        @csrf
        <div class="form-group col-lg-9 col-sm-12">
          <label for="username">Nombre de usuario</label>
          <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <div class="form-group col-lg-9 col-sm-12">
          <label for="password">Contraseña</label>
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
      </form>
    </div>
  </main> --}}
@endsection