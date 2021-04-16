@extends('layouts/main-layout')

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">Tasa de Cambio ({{$originDolar}})</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
          <button class="btn btn-sm btn-outline-secondary"><a href="{{route('indexTasaDolar').'?origin=monitor'}}">Monitor</a></button>
          <button class="btn btn-sm btn-outline-secondary"><a href="{{route('indexTasaDolar').'?origin=bcv'}}">BCV</a></button>
        </div>
        <a href="{{route('agregarTasaDolar')}}" class="btn btn-sm btn-outline-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
          Agregar Tasa
        </a>
      </div>
    </div>

    
    {{-- <div id="react-chart"></div> --}}
    <canvas className="my-4 chartjs-render-monitor" id="myChart" width="696" height="293" style="
      display: block;
      width: 696px;
      height: 293px;
    "></canvas>

    <h2>Log de Tasa de Cambio ({{$originDolar}})</h2>
    <table id="example" class="display" width="100%"></table>
    <div class="table-responsive">
      <table class="table table-striped table-sm" id="list-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Tasa (Bs/$)</th>
            <th>Fecha</th>
            <th>Hora</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="font-weight: 600">Cargando ...</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
@endsection

@section('scripts')
    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [],
          datasets: [{
            label: "Bs/$",
            data: [],
            lineTension: 0.1,
            backgroundColor: 'transparent',
            borderColor: '#3490dc',
            borderWidth: 3,
            pointBackgroundColor: '#007bff'            
            
          }
        ]
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
            display: true,
          }
        }
      });

      var updateTasa = function() {
      $.ajax({
        url: "{{ route('api.chart').'?origin='.strtolower($originDolar) }}",
        type: 'GET',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          myChart.data.labels = data.labels;
          myChart.data.datasets[0].data = data.data;
          myChart.data.datasets[0].label =" Bs/$ ("+data.origin+")";
          myChart.update();
        },
        error: function(data){
          console.log(data);
        }
      });

      $.ajax({
        url: "{{ route('api.chart.list').'?origin='.strtolower($originDolar) }}",
        type: 'GET',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {

          var table = document.getElementById('list-table').getElementsByTagName('tbody')[0];
          
          // Elimina los rows de la table si tiene
          if(table.rows.length){
              table.innerHTML = "";
          }

          data.list.map(function(tasa){
            var newRow = table.insertRow(tasa.rowid);
            newRow.innerHTML = `<td>${tasa.id}</td>
              <td>Bs ${tasa.rate}</td>
              <td>${tasa.date}</td>
              <td>${tasa.time}</td>`;
          });
        },
        error: function(data){
          console.log(data);
        }
      });
    }
    
    updateTasa();
    setInterval(() => {
      updateTasa();
    }, 10000);

    </script>
@endsection