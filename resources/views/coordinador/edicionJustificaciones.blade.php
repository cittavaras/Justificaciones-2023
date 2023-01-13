@extends('layouts.coordinador')
{{-- @include('alert::bootstrap') --}}

@section('utilitiesHead')
  <!-- bootstrap-daterangepicker -->
  <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- Dropzone.js -->
  <link href="/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
    <style>
        #loader{
        visibility:hidden;
        }
    </style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Administracion Justificaciones</h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <!-- Smart Wizard -->
              <form enctype="multipart/form-data" id="my-awesome-dropzone" class="dropzone" action="{{url('coordinador/update', $justifications->ID_DATO)}}" method="post">
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
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly" name='nombre_alum' placeholder="{{$datosAlumno->NOMBRE_ALUM}} {{$datosAlumno->APEP_ALUM}}" value="{{$datosAlumno->NOMBRE_ALUM}} {{$datosAlumno->APEP_ALUM}}">
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly" name='rut_alum' placeholder="Rut: {{$alumno->rut_alu}}" value="Rut: {{$alumno->rut_alu}}">
                          <span class="fa	fa-indent form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess4" readonly="readonly" name='correo_alum' placeholder="{{$datosAlumno->CORREO_ALUM}}" value="{{$datosAlumno->CORREO_ALUM}}">
                          <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" id="inputSuccess7" readonly="readonly" placeholder="{{$alumno->celular}}">
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
                          <label for="fechaFalta" class="control-label">Fecha solicitud:</label>
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly"  name="fec_sol" placeholder="{{ $justifications->FEC_SOL }}" name="{{ $justifications->FEC_SOL }}">
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12  form-group has-feedback" >
                          <label for="fechaFalta" class="control-label">Fechas A justificar:</label>
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly"  name="fec_jus" placeholder="{{ $justifications->FEC_JUS }}" name="{{ $justifications->FEC_JUS }}">
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="col-md-12">
                      <label for="nombreDocente" class="control-label">Asignatura(s) a justificar:</label>
                        <div class="col-md-12 col-sm-12 col-xs-12 f orm-group has-feedback">
                            @foreach ($listaAsignaturasJustificadas as $obj)
                            <span class="btn btn-primary">{{ $obj->ASIGNATURA }}</span>
                            @endforeach
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="col-md-6 col-sm-6 col-xs-12  form-group has-feedback">
                          <label for="nombreDocente" class="control-label">Estado Solicitud::</label>
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly"  placeholder="{{$justifications->ESTADO}}" name="{{$justifications->ESTADO}}">
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 f orm-group has-feedback">
                          <label for="nombreDocente" class="control-label">Motivo Falta:</label>
                          <input type="text" class="form-control" id="inputSuccess6" readonly="readonly" placeholder="{{ $justifications->MOTIVO }}" name="{{ $justifications->MOTIVO }}">
                          <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>


                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <label for="nombreDocente" class="control-label">Comentarios Solicitud:</label>
                        <textarea cols="40" rows="5" id="message" required="required" class="form-control" readonly="readonly" placeholder="{{ $justifications->COMENTARIO }}" name="{{ $justifications->COMENTARIO }}"></textarea>
                      </div>

                      <h2 class="StepTitle">Certificado Alumno (Click para ver)</h2>
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
                          <label>Evaluación:</label>
                          <p>
                            Aprobar:
                            <input type="radio" class="flat" name="estado" id="estado" value="Aprobado" checked="" required /> Rechazar:
                            <input type="radio" class="flat" name="estado" id="estado" value="Rechazado" />
                          </p>
                        </div>
                      </div>

                      <br>
                      <label for="message">Ingrese máximo 1000 caracteres:</label>
                      <textarea cols="40" rows="5" id="message" required="required" class="form-control" name="comentarioRechazo" >{{ $justifications->COMENTARIO_REC }}</textarea>
                    <br>
                 <button  type="submit" id="submit" class="buttonFinish btn btn-default" style="display: inline;">Finalizar</button>
                </div>
              </form>
              <!-- End SmartWizard Content -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->

@endsection

@section('utilities')
  <!-- jQuery Smart Wizard -->
  <script src="/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
  <!-- Dropzone.js -->
  <script src="/vendors/dropzone/dist/min/dropzone.min.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="/vendors/moment/min/moment.min.js"></script>
  <script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap-datetimepicker -->
  <script src="/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

  {{-- <script type="text/javascript">
    Dropzone.options.dropzone =
     {
        maxFilesize: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
           return time+file.name;
        },
        acceptedFiles: ".pdf",
        addRemoveLinks: true,
        timeout: 5000,
        success: function(file, response)
        {
            console.log(response);
        },
        error: function(file, response)
        {
           return false;
        }
}; --}}
{{-- <script>
    // CSRF for all ajax call
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });
</script>
  <script type="text/javascript">
     function onFinishCallback(objs, context){
         console.log(document.getElementById('message').value.length);
            if( document.getElementById('message').value.length > 1 ) {
              var boton = document.getElementById("submit");
               boton.disabled=true;
                $('form').submit();
        }
    Dropzone.autoDiscover = false;
    jQuery(document).ready(function() {

      $("div#my-awesome-dropzone").dropzone({
        url: "image/upload/store"
      });
    });

    Dropzone.options.myAwesomeDropzone =
    {
    acceptedFiles: ".pdf",
    autoProcessQueue: true,
    uploadMultiple: true,
    parallelUploads: 2,
    maxFiles: 2,
    maxFilesize: 3,
    };
  </script> --}}

    <script type="text/javascript">
      Dropzone.autoDiscover = false;
      // jQuery(document).ready(function() {
      $(document).ready(function () {
        var folio = $('#folio').val();
        console.log(folio);
        Dropzone.autoDiscover = false;
        $("div#my-awesome-dropzone").dropzone({
          url: "image/upload/store/",
          maxFiles: 3,
          maxFilesize: 20,
          dictResponseError: "Error al subir el archivo",
          dictInvalidFileType: "Solo archivos tipo Imagen",
          dictMaxFilesExceeded: "Disculpa, solo puedes subir un maximo de 3 archivos!",
          paramName: "file",
          dictFileTooBig: "Archivo demasiado largo, tamaño maximo 2MB.",
          acceptedFiles: "image/jpeg, image/png, image/jpg",
          params: {
            folio: folio
          },
          headers: {
            'X-CSRFToken': $('meta[name="token"]').attr('content')
          },
        });
      });
    </script>
@endsection

{{-- Dropzone.prototype.defaultOptions.dictDefaultMessage = "Drop files here to upload";
Dropzone.prototype.defaultOptions.dictFallbackMessage = "Your browser does not support drag'n'drop file uploads.";
Dropzone.prototype.defaultOptions.dictFallbackText = "Please use the fallback form below to upload your files like in the olden days.";
Dropzone.prototype.defaultOptions.dictFileTooBig = "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.";
Dropzone.prototype.defaultOptions.dictInvalidFileType = "You can't upload files of this type.";
Dropzone.prototype.defaultOptions.dictResponseError = "Server responded with {{statusCode}} code.";
Dropzone.prototype.defaultOptions.dictCancelUpload = "Cancel upload";
Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "Are you sure you want to cancel this upload?";
Dropzone.prototype.defaultOptions.dictRemoveFile = "Remove file";
Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "You can not upload any more files."; --}}
