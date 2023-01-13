@extends('layouts.admin')

@section('content')
  <!-- page content -->
  {{-- <div class="right_col" role="main"> --}}
    <!-- top tiles -->
    <div class="container">
      <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-edit"></i> Total Emitidas</span>
          <div class="count">{{ $cantEmitidas }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-check-circle-o  "></i> Total Aprobadas</span>
          <div class="count">{{ $cantAprobadas }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-times-circle-o"></i> Total Rechazadas</span>
          <div class="count">{{ $cantRechazadas }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-clock-o"></i> Total Pendientes</span>
          <div class="count">{{ $cantPendientes }}</div>
        </div>
      </div>
    </div>
    <!-- /top tiles -->
    <div class="">
        <div class="page-title">
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">
                  <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Coordinador</th>
                        <th>Aprobadas</th>
                        <th>Rechazadas</th>
                        <th>Pendientes</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        {{-- {{ $justificacion }} --}}
                        @foreach ($coordinadores as $obj )
                          <tr >
                            <td>{{ $obj->CORREO_COR }}</td>
                            <td>{{ $obj->Aprobadas  }}</td>
                            <td>{{ $obj->Rechazadas }}</td>
                            <td>{{ $obj->Pendientes }}</td>
                            <td>{{ $obj->Total      }}</td>
                          </tr>
                        @endforeach

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  {{-- </div> --}}
@endsection
