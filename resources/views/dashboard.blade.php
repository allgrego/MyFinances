@extends('layouts/main-layout')

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">Tasa de Cambio ({{$originDolar}})</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
          <button class="btn btn-sm btn-outline-secondary"><a href="{{route('dashboard').'?origin=monitor'}}">Monitor</a></button>
          <button class="btn btn-sm btn-outline-secondary"><a href="{{route('dashboard').'?origin=bcv'}}">BCV</a></button>
        </div>
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          This week
        </button>
      </div>
    </div>

    
    <div id="react-chart"></div>

    <h2>Log de Tasa de Cambio ({{$originDolar}})</h2>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>Tasa (Bs/$)</th>
            <th>Fecha</th>
            <th>Hora</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tasaDolar as $tasaDiaria)
          <tr>
              <td>{{$tasaDiaria->id}}</td>
              <td>Bs {{(float)$tasaDiaria->rate}}</td>
              <td>{{$tasaDiaria->date}}</td>
              <td>{{$tasaDiaria->time}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </main>
@endsection

@section('scripts')
    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
    const ctx = document.getElementById("myChart");
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [
            @foreach($tasaDataset['date'] as $date) 
                "{{$date}}",
            @endforeach
            ],
          datasets: [{
            data: [
                @foreach($tasaDataset['rate'] as $rate) 
                    {{$rate}},
                @endforeach
                ],
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    </script>
@endsection