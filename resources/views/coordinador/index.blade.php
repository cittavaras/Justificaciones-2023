@extends('layouts.coordinador')

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
    <div class="">
    <div class="page-title">
        <div class="title_left">
          <h3>Lista de Solicitudes</small></h3>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
             <div class="x_content">
               <div class="" role="tabpanel" data-example-id="togglable-tabs">
                 <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                   <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Pendientes</a>
                   </li>
                   <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Aprobadas</a>
                   </li>
                   <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Rechazadas</a>
                   </li>
                 </ul>
                 <div id="myTabContent" class="tab-content">
                   <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                     <table id="" class="display table table-striped table-bordered">
                       <thead>
                         <tr>
                         <th>N° Folio</th>
                         <th>Alumno</th>
                         <th>Rut</th>
                         <th>Fecha Solicitud</th>
                         <th>Motivo</th>
                         <th>Fechas justificacion</th>
                         <th>Estado</th>
                         <th>#</th>
                         </tr>
                       </thead>
                       <tbody>
                         @foreach ($listaJustificacionesValidando as $obj)
                           <tr>
                              <td>{{ $obj->nfolio }}</td>
                              <td>{{ $obj->NOMBRE_ALUM }}</td>
                              <td>{{ $obj->RUT_ALU }}</td>
                              <td>{{ $obj->fec_sol }}</td>
                              <td>{{ $obj->motivo }}</td>
                              <td>{{ substr($obj->FEC_JUS,0, 10) }} a {{ substr($obj->FEC_JUS,12, 22) }}</td>
                              <td>{{ $obj->ESTADO }}</td>
                              <td><a href="{{ url('coordinador/edicion', $obj->nfolio) }}">Responder</a></td>
                           </tr>
                       @endforeach
                       </tbody>
                     </table>
                   </div>
                   <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                     <table id="" class="display table table-striped table-bordered">
                       <thead>
                         <tr>
                            <th>N° Folio</th>
                            <th>Alumno</th>
                            <th>Rut</th>
                            <th>Fecha Solicitud</th>
                            <th>Motivo</th>
                            <th>Fechas justificacion</th>
                            <th>Estado</th>
                            <th>#</th>
                         </tr>
                       </thead>
                       <tbody>
                         @foreach ($listaJustificacionesAprobadas as $obj)
                           <tr>
                           <td>{{ $obj->nfolio }}</td>
                           <td>{{ $obj->NOMBRE_ALUM }}</td>
                           <td>{{ $obj->RUT_ALU  }}</td>
                           <td>{{ $obj->fec_sol }}</td>
                           <td>{{ $obj->motivo }}</td>
                           <td>{{ substr($obj->FEC_JUS,0, 10) }} a {{ substr($obj->FEC_JUS,12, 22) }}</td>
                           <td>{{ $obj->ESTADO }}</td>
                           <td><a href="{{ url('coordinador/edicion', $obj->nfolio) }}">Editar</a></td>
                           </tr>
                       @endforeach
                       </tbody>
                     </table>
                   </div>
                   <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                     <table id="" class="display table table-striped table-bordered">
                       <thead>
                         <tr>
                            <th>N° Folio</th>
                            <th>Alumno</th>
                            <th>Rut</th>
                            <th>Fecha Solicitud</th>
                            <th>Motivo</th>
                            <th>Fechas justificacion</th>
                            <th>Estado</th>
                            <th>#</th>
                         </tr>
                       </thead>
                       <tbody>
                         @foreach ($listaJustificacionesRechazadas as $obj)
                           <tr>
                           <td>{{ $obj->nfolio }}</td>
                           <td>{{ $obj->NOMBRE_ALUM }}</td>
                           <td>{{ $obj->RUT_ALU  }}</td>
                           <td>{{ $obj->fec_sol }}</td>
                           <td>{{ $obj->motivo }}</td>
                           <td>{{ substr($obj->FEC_JUS,0, 10) }} a {{ substr($obj->FEC_JUS,12, 22) }}</td>
                           <td>{{ $obj->ESTADO }}</td>
                           <td><a href="{{ url('coordinador/edicion', $obj->nfolio) }}">Editar</a></td>
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
    $(document).ready(function() {
      $('table.display').DataTable({
        "order": [[ 4, "asc" ]],
        "language": {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
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
