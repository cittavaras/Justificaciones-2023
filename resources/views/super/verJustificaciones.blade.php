@extends('layouts.super')

@section('utilitiesHead')
  <!-- bootstrap-daterangepicker -->
  <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <style>
        #loader{
        visibility:hidden;
        }
    </style>
  <title>blabla</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Ver Justificacion</h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <!-- Smart Wizard -->

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" id="folio" name="folio" value="{{$folio}}">
                <input type="hidden" id="inputSuccess3" name="apem_alum" value="{{$datosAlumno->APEM_ALUM}}">
                <input type="hidden" id="cursosArray" name="cursosArray">
                <input type="hidden" id="correoDocente" name="correoDocente">
                <input type="hidden" id="correoCoordinador" name="correoCoordinador">
                    <div>

                    </div>
                      <div class="form-horizontal form-label-left">
                        {{-- @foreach($datosAlumno as $key => $data) --}}
                        {{-- @foreach($datosAlumno as $data)
                            <tr>
                                <th>{{$data->nombre_alum}}</th>
                                <th>{{$data['correo_alum']}}</th>
                            </tr>
                        @endforeach --}}
                        {{-- {{$datosAlumno->CORREO_ALUM}} --}}
                        {{-- {{ print_r($datosAlumno, true) }} --}}
                        {{-- {{ print_r($infoCursos, true) }} --}}
                        {{-- {{$datosAlumno->'correo_alum'}} --}}
                        <h2 class="StepTitle">Datos Academicos Alumno</h2>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly" name='nombre_alum' placeholder="{{$datosAlumno->NOMBRE_ALUM}}" value="{{$datosAlumno->NOMBRE_ALUM}}">
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" id="inputSuccess3" readonly="readonly" name='apep_alum' placeholder="{{$datosAlumno->APEP_ALUM}}" value="{{$datosAlumno->APEP_ALUM}}">
                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess4" readonly="readonly" name='correo_alum' placeholder="{{$datosAlumno->CORREO_ALUM}}" value="{{$datosAlumno->CORREO_ALUM}}">
                          <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" id="inputSuccess7" readonly="readonly" placeholder="{{$datosAlumno->CELULAR}}">
                          <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" id="inputSuccess6" readonly="readonly" placeholder="Cordinador">
                          <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
                        </div> -->

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess4" readonly="readonly" name='correo_alum' placeholder="{{$datosAlumno->CARRERA}}" value="{{$datosAlumno->CARRERA}}">
                          <span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" id="inputSuccess8" readonly="readonly" name="jornada" placeholder="{{$datosAlumno->JORNADA}}">
                          <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
                        </div>

                      </div>


                      <h2 class="StepTitle">Datos Solicitud Alumno</h2><br>
                      <div class="col-md-12">
                        <div class="col-md-6 col-sm-6 col-xs-12  form-group has-feedback" >
                          <label for="fechaFalta" class="control-label">Fechas Falta:</label>
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly"  name="fec_jus" placeholder="{{ $justifications->FEC_JUS }}" name="{{ $justifications->FEC_JUS }}">
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 f orm-group has-feedback">
                          <label for="nombreDocente" class="control-label">Motivo Falta:</label>
                          <input type="text" class="form-control" id="inputSuccess6" readonly="readonly" placeholder="{{ $justifications->MOTIVO }}" name="{{ $justifications->MOTIVO }}">
                          <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="col-md-6 col-sm-6 col-xs-12  form-group has-feedback">
                          <label for="nombreDocente" class="control-label">Docente:</label>
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly"  name="nombre_doc" placeholder="{{$datosAlumno->NOMBRE_DOC}} {{$datosAlumno->APEP_DOC}}" name="{{$datosAlumno->NOMBRE_DOC}}">
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 f orm-group has-feedback">
                          <label for="nombreDocente" class="control-label">Asignatura:</label>
                          <input type="text" class="form-control" id="inputSuccess6" readonly="readonly"  name="asignatura" placeholder="{{ $justifications->ASIGNATURA }}" value="{{ $justifications->ASIGNATURA }}">
                          <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>



                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <label for="nombreDocente" class="control-label">Comentarios Solicitud:</label>
                        <textarea cols="40" rows="5" id="message" required="required" class="form-control" readonly="readonly" placeholder="{{ $justifications->COMENTARIO }}" name="{{ $justifications->COMENTARIO }}"></textarea>
                      </div>

                      <h2 class="StepTitle">Certificado Alumno > (Click para abrir imagenes.)</h2>
                      <div class="container">
                            @foreach ($imagenes as $key => $imagen )
                                <div class="list-group">
                                    <a href="{{'/storage/'.$imagen->url}}" class="list-group-item list-group-item-action" target="_blank">
                                     <h4 class="list-group-item-heading">Imagen {{$key+1}}</h4>
                                     <p class="list-group-item-text">URL:{{$imagen->url}}</p>
                                     <p class="list-group-item-text">Folio:{{$imagen->nfolio}}</p>
                                    </a>
                                </div>
                            @endforeach
                      </div>
                      <h2 class="StepTitle">Evaluación y Comentarios</h2><br>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label>Estado:</label>
                          <p>
                            <input type="text" class="form-control" id="inputRespuesta" readonly="readonly" placeholder="{{ $justifications->ESTADO }}" name="{{ $justifications->ESTADO }}">
                          </p>
                        </div>
                      </div>

                      <br>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <label for="nombreDocente" class="control-label">Respuesta Solicitud:</label>
                        <textarea cols="40" rows="5" id="message" class="form-control" readonly="readonly" placeholder="{{ $justifications->COMENTARIO_REC }}" name="{{ $justifications->COMENTARIO_REC }}"></textarea>
                   </div>
                </div>
              <!-- End SmartWizard Content -->
            </div>
            <a href="{{ url('super/index')  }}" class="btn btn-default"> Volver </a>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->

@endsection

@section('utilities')
  <!-- bootstrap-daterangepicker -->
  <script src="/vendors/moment/min/moment.min.js"></script>
  <script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap-datetimepicker -->
  <script src="/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


 <script>
    // CSRF for all ajax call
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
    </script>
  @endsection
