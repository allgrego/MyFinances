@extends('layouts/main-layout')

@section('content')
  {{-- Page Heading --}}
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tasa de Cambio ({{$originDolar}})</h1>
    <a href="{{route('indexTasaDolar').'?origin='}}{{$originDolar=='BCV'?'monitor':'bcv'}}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
      class="fas fa-toggle-off fa-sm text-white-50"></i> Ver {{$originDolar == 'BCV'?'Monitor Dolar':'BCV'}}</a>
    <a href="{{route('agregarTasaDolar').'?origin='}}{{$originDolar=='BCV'?'bcv':'monitor'}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
      class="fas fa-plus-circle fa-sm text-white-50"></i> Agregar Tasa</a>
  </div>

  {{-- Content Row --}}
  <div class="row">
    {{-- Area Chart --}}
    <div class="col-xl-6 col-lg-6 col-md-12 order-lg-last order-md-first">
      <div class="card shadow mb-4">
          {{-- Card Header - Dropdown --}}
          <div
              class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Gráfica</h6>
              <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                      aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                  </div>
              </div>
          </div>
          {{-- Card Body --}}
          <div class="card-body">
              <div class="chart-area">
                  <canvas id="myAreaChart"></canvas>
              </div>
          </div>
      </div>
    </div>
    <!-- DataTales Example -->
  <div class="col-xl-6 col-lg-6 col-md-12 order-lg-first order-md-last">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Log</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>Tasa (Bs/$)</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>id</th>
                      <th>Tasa (Bs/$)</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr>
                      <td style="font-weight: 700">Cargando ...</td>
                    </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>

  </div>

</div>
@endsection

@section('scripts')
    <script>
      var updateTasa = function() {

        console.log("{{ route('api.dolar').'?amount=5&origin='.strtolower($originDolar) }}");
      // Chart Data
      $.ajax({
        url: "{{ route('api.dolar')}}?amount=5&order=last&origin={{strtolower($originDolar)}}",
        type: 'GET',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          myLineChart.data.labels = data.labels;
          myLineChart.data.datasets[0].data = data.data;
          myLineChart.data.datasets[0].label =" Bs/$ ("+data.origin+")";
          myLineChart.update();
        },
        error: function(data){
          console.log(data);
        }
      });

      // Table Data
      $.ajax({
        url: "{{ route('api.chart.list').'?origin='.strtolower($originDolar) }}",
        type: 'GET',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {

          var table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
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
    }, 1000*5);
    </script>        
@endsection