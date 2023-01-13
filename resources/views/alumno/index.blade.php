@extends('layouts.alumno')

@section('utilitiesHead')
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')

  <!-- page content -->
  <div class="right_col" role="main">
    <!-- top tiles -->
    <div class="container col-md-offset-2">
      <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-edit"></i> Justicaciones Emitidas</span>
          <div class="count">{{ $cantEmitidas }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-check-circle-o  "></i> Aprobadas</span>
          <div class="count">{{ $cantAprobadas }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-times-circle-o"></i> Rechazadas</span>
          <div class="count">{{ $cantRechazadas}}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-clock-o"></i> Total Pendientes</span>
          <div class="count">{{ $cantPendientes }}</div>
        </div>
        <div class="col-md-1 " style="padding-top:20px">
          <a href="{{ url('/alumno/nuevaJustificacion') }}"  class="btn btn-round btn-success">Crear Justificación</a>
        </div>
      </div>
    </div>
    <!-- /top tiles -->

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
    @endif
    <div class="">
        <div class="page-title">
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">
                  <table id="datatable" class="table table-striped table-bordered" style="text-align:center">
                    <thead >
                      <tr>
                        <th>Fecha Solicitud</th>
                        <th>Motivo</th>
                        <th>Fecha Inicio Ausencia</th>
                        <th>Fecha Fin Ausencia</th>
                        <th>Estado</th>
                        <th>#</th>
                      </tr>
                    </thead>
                    <tbody>
                        {{-- {{ $justificacion }} --}}
                      @foreach ($justificacion as $obj)
                        <tr >
                          <td>{{ $obj->fec_sol }}</td>
                          <td>{{ $obj->motivo }}</td>
                          <td>{{ substr($obj->FEC_JUS,0, 10) }}</td>
                          <td>{{ substr($obj->FEC_JUS,12, 22) }}</td>
                          <td>{{ $obj->ESTADO }}</td>
                          <td><a href="{{ url('alumno/ver', $obj->nfolio) }}">Ver</a></td>
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


  </div>
  <!-- /page content -->
@endsection


@section('utilities')
  <!-- Datatables -->
  <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="../vendors/jszip/dist/jszip.min.js"></script>
  <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

  <script type="text/javascript">
  $(document).ready( function () {
    $('#datatable').DataTable(
      {
            language: {
              "sProcessing":     "Procesando...",
              "sLengthMenu":     "Mostrar _MENU_ registros",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "No tienes justificaciones pendientes!!",
              "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sSearch":         "Buscar:",
              "sUrl":            "",
              "sInfoThousands":  ",",
              "sLoadingRecords": "Cargando...",
              "oPaginate": {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
              },
              "oAria": {
                  "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
              }
          }
        }
    );
  });
  </script>
@endsection
