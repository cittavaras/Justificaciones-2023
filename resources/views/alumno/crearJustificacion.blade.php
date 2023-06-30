
@extends('layouts.alumno')
{{-- @include('alert::bootstrap') --}}

@section('utilitiesHead')
  <!-- bootstrap-daterangepicker -->
  {{-- <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"> --}}
  <!-- Dropzone.js -->
  <link href="/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
  <link href="/build/css/mi_css.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
    <style>
      #loader{
        visibility:hidden;
      }
    </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')
<div class="row pop-up">
  <div class="caja small-6 large-centered">
    <a href="#" class="close-button">&#10006;</a>
    <br>
      <h1>Documentación válida</h1>
      <ol id="lista2">
    <li>Certificado médico o Licencia Médica</li>
    <li>Certificado laboral</li>
    <p>Especifíco</p>
    <p>* no aplica contrato de trabajo</p>
    <li>Seleccionados Nacionales(Deportes)</li>
</ol>
<h1 class="titulo">Plazo</h1>
<h1 class="titulo">3 días hábiles</h1>
<h3 class="subtitulo">desde el reintegro</h3>
  </div>
</div>
  <!-- page content -->
  <div class="blur-in" id="overlay">
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Creando Justificativo</h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <!-- Smart Wizard -->
              <div id ="alertBox" class="alert alert-danger" style="opacity: 0" onclick="ocultarAlerta()"></div>
              @if(count($errors))
              <div class="alert alert-danger">
                <strong>Ups!</strong> Algo no anda bien con tu solicitud de justificación.
                <br/>
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <form enctype="multipart/form-data" id="my-awesome-dropzone" class="dropzone" action="{{url('alumno/store')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" id="folio" name="folio" value="{{$folio}}">
                <input type="hidden" id="inputSuccess3" name="apem_alum" value="{{$datosAlumno->APEM_ALUM}}">
                <input type="hidden" id="cursosArray" name="cursosArray">
                <input type="hidden" id="correoDocente" name="correoDocente">
                <input type="hidden" id="correoCoordinador" name="correoCoordinador">
                <input type="hidden" id="rut_alu" name="rut_alu" value="{{$datosAlumno->RUT_ALU}}">
 <!--               <input type="hidden" id="seccion" name="seccion"> -->
                <input type="hidden" id="seccion" name="seccion">
                <input type="hidden" id="subioArchivo" name="subioArchivo">
                <input type="hidden" id="seleccionoFecha" name="seleccionoFecha">
                <!-- dado los rangos de fecha, sacar en un arreglo los días que se ha ausentado el 
                    alumno, dado esos días en un arreglo , devolver un arreglo con los ramos -->
                <div id="wizard" class="form_wizard wizard_horizontal">
                  <ul class="wizard_steps">
                    <li>
                      <a href="#step-1">
                        <span class="step_no">1</span>
                        <span class="step_descr">
                          Paso 1<br />
                          <small>Mis Datos Académicos</small>
                      </span>
                      </a>
                    </li>
                    <li>
                      <a href="#step-2">
                        <span class="step_no">2</span>
                        <span class="step_descr">
                          Paso 2<br />
                          <small>Datos Solicitud</small>
                        </span>
                      </a>
                    </li>
                    <li>
                    <a href="#step-3">
                      <span class="step_no">3</span>
                      <span class="step_descr">
                        Paso 3<br />
                        <small>Cargar Certificado</small>
                      </span>
                    </a>
                  </li>
                    <li>
                      <a href="#step-4">
                        <span class="step_no">4</span>
                        <span class="step_descr">
                          Paso 4<br />
                          <small>Comentario</small>
                        </span>
                      </a>
                    </li>
                  </ul>
                    <div id="step-1">
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
                        <h2 class="StepTitle">Mis datos Académicos</h2>
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
                          <input type="text" class="form-control" id="inputSuccess5"  placeholder="Telefono/Celular" name="celular_alum" value="{{$datosAlumno->CELULAR}}" maxlength="9">
                          <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                        </div>

                        <!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" id="inputSuccess6" readonly="readonly" placeholder="Cordinador">
                          <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
                        </div> -->

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" id="inputSuccess7" readonly="readonly" placeholder="{{$datosAlumno->CARRERA}}">
                          <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" id="inputSuccess8" readonly="readonly" placeholder="{{$datosAlumno->JORNADA}}">
                          <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
                        </div>

                      </div>
                    </div>
                    <div id="step-2" style="overflow:auto; height:480px">
                      <h2 class="StepTitle">Datos Solicitud</h2><br>

                      <div class="col-md-12">
                        ¿Qué fechas faltaste?
                        <div class="input-prepend input-group">
                          <span id="reservation1" class="add-on input-group-addon"><i id="miCalendario" class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          <input type="text" style="width: 200px" name="fechaJustificacion" id="reservation-time" class="form-control"/>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label for="nombreDocente" class="control-label">Docente:</label>
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" readonly="readonly"  placeholder="Nombre Docente" name="nombreDocente">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label for="nombreDocente" class="control-label">Coordinador:</label>
                        <input type="text" class="form-control" id="inputSuccess6" readonly="readonly" placeholder="Nombre Cordinador" name="nombreCoordinador">
                        <span class="fa fa-institution form-control-feedback right" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <select class="form-control" id="carritoJC" name="asignatura" placeholder="Asignatura">
                            <option value='null'>Seleccionar asignatura</option>
                            @foreach($infoCursos as $item)
                                <option value="{{$item['NOM_ASIG']}}">{{$item['NOM_ASIG']}}</option>
                            @endforeach
                        </select>
                        <span class="fa fa-folder form-control-feedback right" aria-hidden="true"></span>
                      </div>
                            {{-- <div class="col-md-9">
                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                Asignaturas que serán justificadas
                              </div>
                            </div> --}}
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <select class="form-control" name="motivo" id="motivoId">
                          <option value=''>Seleciona un motivo</option>
                          <option value='Medico'>Médico</option>
                          <option value='Laboral'>Laboral</option>
                          <option value='Actividad Extracurricular'>Actividad Extracurricular</option>
                          <option value='Otro'>Otro</option>
                        </select>
                        <span class="fa fa-book form-control-feedback right" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <span id="loader"><i class="form-control-feedback fa fa-spinner fa-3x fa-spin"></i></span>
                        <label for="panel-asignaturas" class="control-label has-feedback">Asignaturas que serán justificadas:</label>
                        <label for="panel-asignaturas" class="control-label has-feedback">(Click sobre asignatura para eliminar)</label>
                        <div id="panel-asignaturas" class="form-group has-feedback">No has seleccionado Asignaturas</div>
                        <div class="form-group">
                          {{-- <div class="col-sm-offset-3 col-sm-6"> --}}
                            <button class="btn btn-default form-group has-feedback" id="carrito">
                                <i class="fa fa-plus"></i> Agregar Asignatura a la justificacion
                            </button>
                          {{-- </div> --}}
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          ¿Faltaste a alguna evaluación?
                        <div class="checkbox form-group">
                          <label>
                            <input name="tipoInasistencia" type="radio" name="opcion" value="SI" id="siprueba" class="validarStep"> SI
                          </label>
                        </div>
                        <div class="checkbox form-group">
                          <label>
                            <input name="tipoInasistencia" type="radio" name="opcion" value="NO" id="noprueba" class="validarStep" checked> NO
                          </label>
                        </div>
                      </div>
                    </div>
                    <div id="step-3">
                      <h2 class="StepTitle">Paso 3 Cargar Certificado</h2>
                      <div class="x_content">
                        <p>Arrastre las fotos que necesita subir o haga click en el panel</p>
                        <p><h5> Restricciones: img/jpg, img/png, tamaño máximo 3MB, cantidad máxima 3 documentos</h5></p>
                        {{-- <form method="post" action="{{url('image/upload/store')}}" enctype="multipart/form-data" class="dropzone dropzone-previews" id="my-awesome-dropzone">
                            @csrf
                        </form> --}}
                        <div class="dropzone dropzone-previews" id="my-awesome-dropzone"></div>
                        <br />
                        <br />
                        <br />
                        <br />
                      </div>
                    </div>
                    <div id="step-4">
                      <h2 class="StepTitle">Paso 4 Comentario</h2>
                      <label for="message">Ingrese mínimo 30 caracteres y máximo 500: (caracteres ingresados </label>
                      <label for="message"><div id="count"></div></label>
                      <label for="message">)</label>
                      <label for="message">CUANDO TU SOLICITUD SE ENCUENTRE TERMINADA PRESIONA EL BOTON FINALIZAR</label>
                      <textarea cols="40" rows="5" id="message" required="required" class="form-control" name="comentario"></textarea>
                    </div>
                    {{-- <div class="form-group">
                        <button type="submit" class="btn btn-primary" value="Send">Send</button>
                    </div> --}}
                </div>
              </form>
              <!-- End SmartWizard Content -->
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
  <!-- jQuery Smart Wizard -->
  <script src="/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
  <!-- Dropzone.js -->
  <script src="/vendors/dropzone/dist/min/dropzone.min.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="../vendors/moment/min/moment.min.js"></script>
  <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap-datetimepicker -->
  <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  <script>
    $(function() {
  $('.pop-up').hide();
  $('.pop-up').fadeIn(1000);
  
      $('.close-button').click(function (e) { 

      $('.pop-up').fadeOut(700);
      $('#overlay').removeClass('blur-in');
      $('#overlay').addClass('blur-out');
      e.stopPropagation();
        
    });
 });
 </script>
  <script type="text/javascript">
    function ocultarAlerta() {
        document.getElementById("alertBox").style.opacity=0;
    }
    $(document).ready(function(){
        $("#message").keyup(function(){
            $("#count").text($(this).val().length);
        });
        $('input[name=fechaJustificacion]').daterangepicker();
            $(document).on("click",".applyBtn",function() {
                $("#seleccionoFecha").val('sip');
            });
        // Smart Wizard
        $('#wizard').smartWizard({
            onLeaveStep:leaveAStepCallback,
            onFinish:onFinishCallback
        });

        function leaveAStepCallback(obj, context){
            return validateSteps(context.fromStep)
            // if (context.fromStep != 1){
            // }
            // if (validateSteps(context.fromStep)){
            //     return true;
            // } else {
            //     // alert("Te faltan datos por completar, por favor vuelve a revisar");
            //     return false;
            // }
            // return validateSteps(context.fromStep); // return false to stay on step and true to continue navigation
        }

        function onFinishCallback(objs, context){
            console.log(document.getElementById('message').value.length);
            if( document.getElementById('message').value.length > 30 && document.getElementById('message').value.length < 500) {
              $(".actionBar .buttonFinish").attr('disabled', 'disabled');
                $('form').submit();
            } else {
                document.getElementById("alertBox").style.opacity=1;
                document.getElementById("alertBox").innerHTML="Debes completar el comentario de forma correcta...(Click para cerrar)";
                // alert("Debes completar el comentario de forma correcta");
            }
        }

        // Your Step validation logic
        function validateSteps(stepnumber){
            var isStepValid = true;
            if(stepnumber == 1){
                return true;
            }
            if(stepnumber == 2){
                var m = document.getElementById("motivoId");
                if( document.getElementById('seleccionoFecha').value === "" ) {
                    document.getElementById("alertBox").style.opacity=1;
                    document.getElementById("alertBox").innerHTML="Debes indicar las fechas de tu inasistencia...(Click para cerrar)";
                    // alert("Debes indicar un rango de fechas");
                    isStepValid = false;
                } else if( document.getElementById('panel-asignaturas').innerHTML === "No has seleccionado Asignaturas" ||
                           document.getElementById('panel-asignaturas').innerHTML =="" ) {
                    document.getElementById("alertBox").style.opacity=1;
                    document.getElementById("alertBox").innerHTML="Debes seleccionar al menos una asignatura...(Click para cerrar)";
                    // alert("Debes seleccionar al menos una asignatura");
                    isStepValid = false;
                } else if ( m.options[m.selectedIndex].value === '') {
                    document.getElementById("alertBox").style.opacity=1;
                    document.getElementById("alertBox").innerHTML="Debes seleccionar un motivo...(Click para cerrar)";
                    // alert("Debes seleccionar un motivo");
                    isStepValid = false;
                } else if ( !document.getElementById("siprueba").checked && !document.getElementById("noprueba").checked) {
                    document.getElementById("alertBox").style.opacity=1;
                    document.getElementById("alertBox").innerHTML="Debes indicar si faltaste o no a alguna evaluación...(Click para cerrar)";
                    // alert("Debes indicar si faltaste a alguna evaluación");
                    isStepValid = false;
                }
                return isStepValid;
            }
            if(stepnumber == 3){
                if( document.getElementById('subioArchivo').value === "" ) {
                    document.getElementById("alertBox").style.opacity=1;
                    document.getElementById("alertBox").innerHTML="Debes subir al menos una imagen a tu justificación...(Click para cerrar)";
                    // alert("Debes subir al menos ua imagen a tu justificación");
                    isStepValid = false;
                }
                return isStepValid;
            }
            return isStepValid;
        }
        // function validateAllSteps(){
        //     var isStepValid = true;
        //     return isStepValid;
        // }
    });
    </script>

  <script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(document).ready(function () {
      var today = new Date();
      var endDate = new Date(today.getTime() + 1 * 24 * 60 * 60 * 1000);
      $('input[name=fechaJustificacion]').daterangepicker({
        "locale": {
          "format": "DD/MM/YYYY",
          "separator": " - ",
          "applyLabel": "Aplicar",
          "cancelLabel": "Deshacer",
          "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
          ],
          "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
          ],
          "firstDay": 1
        },
        "startDate": moment(endDate).format('DD/MM/YYYY'),
        "endDate": moment(endDate).format('DD/MM/YYYY'),
        "singleDatePicker": false
      });
      Dropzone.autoDiscover = false;
      $("div#my-awesome-dropzone").dropzone({
        url: "image/upload/store/",
        maxFiles: 3,
        maxFilesize: 3,
        dictResponseError: "Error al subir el archivo",
        dictInvalidFileType: "Solo archivos tipo Imagen",
        dictMaxFilesExceeded: "Lo sentimos, solo puedes subir un maximo de 3 archivos!",
        paramName: "file",
        dictFileTooBig: "Archivo demasiado largo, tamaño maximo 3MB.",
        acceptedFiles: "image/jpeg, image/png, image/jpg",
        params: {
          folio: $('#folio').val()
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
          this.on("success", function(file, responseText) {
            $("#subioArchivo").val('sip');
          });
        },
      });
      $('select[name="asignatura"]').on('change', function(){
        var asignaturaId = $(this).val();
        if(asignaturaId) {
          $.ajax({
            url: '/asignaturas/get/'+asignaturaId,
            type:"GET",
            dataType:"json",
            beforeSend: function(){
              $('#loader').css("visibility", "visible");
              $('#carrito').attr("disabled", true);
            },
            success:function(data) {
              $('input[name=correoDocente]').val(data[0].CORREO_DOC);
              $('input[name=correoCoordinador]').val(data[0].CORREO_COR);
              $('input[name=seccion]').val(data[0].COD_SECCION);
              $('input[name=nombreDocente]').val(data[0].NOMBRE_DOC + ' ' + data[0].APEP_DOC);
              $('input[name=nombreCoordinador]').val(data[0].NOMBRE_COR + ' ' + data[0].APEP_COR);
            },
            complete: function(){
              $('#loader').css("visibility", "hidden");
              $('#carrito').attr("disabled", false);
            }
          });
        }
      });
  $(function() {
        var arr = [];
        $("#carrito").click(function() {
          var selectobject=document.getElementById("carritoJC");
          if ($('#carritoJC').find(":selected").text() != 'Seleccionar asignatura') {
            arr.push({
              asignatura: $('#carritoJC').find(":selected").text(),
              correoDocente: $('input[name=correoDocente]').val(),
              correoCoordinador: $('input[name=correoCoordinador]').val(),
              seccion: $('input[name=seccion]').val()
            });
            console.log(arr)
            display_asignaturas(arr);
            for (var i=0; i<selectobject.length; i++){
              if (selectobject.options[i].value == $('#carritoJC').find(":selected").text() )
                selectobject.remove(i);
              }
            }
          }
        );
        $(document).on('click', '.ramo', function () {
         var selectobject=document.getElementById("carritoJC");
         nombre = this.innerHTML;
         posicion =-1;
           for (var i = 0; i < arr.length; i++) {
             if(arr[i].asignatura ==nombre)
              {
               posicion=i;
              }
           }
           var opt = document.createElement('option');
           opt.value = nombre;
           opt.innerHTML = nombre;
           selectobject.appendChild(opt);
           arr.splice( posicion, 1 );
           console.log(arr)
           display_asignaturas(arr);
         }
        );
      });
      function display_asignaturas(arr) {
        var newHTML = "";
        if(arr.length >0){
          for (var i = 0; i < arr.length; i++) {
            newHTML = newHTML + '<span class="ramo" ">'+ arr[i].asignatura + '</span>';
          }
        }
        $("#panel-asignaturas").html(newHTML);
        $("#cursosArray").val(JSON.stringify(arr));
      }

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
