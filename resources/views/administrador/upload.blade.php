@extends('layouts.admin') @section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
  <div class="container ">
    <!-- top tiles -->
    <form
      id="carga-form"
      method="POST"
      action="{{ route('cargadatos') }}"
      accept-charset="UTF-8"
      enctype="multipart/form-data"
    >
      <!-- <div class="form-group"> -->
        {{ csrf_field() }}
        <h1 class="t-h1">Carga de Datos<span class="t-span"> Semestrales</span></h1>
        
          <div class="pa">

            <div>
              Este procedimiento actualizará los datos de la plataforma.
            </div>
            <div>
              <i><b>Los datos anteriores serán borrados.</b></i> 
            </div>
          </div>

          <p class="pa">
            Para limpiar el registro de justificaciones, diríjase a <a href={{ url('/administrador/cierresemestre') }}>cierre de semestre</a>.
          </p>
	  <p class="pa">
	    El sistema requiere que el archivo sea con formato <i><b>.XLSX</b></i>
	  </p>        
          <div class="file-area">
            <input
              id="archivo-xlsx"
              type="file"
              accept=".xlsx"
              name="archivo-xlsx"
              required
            />
            <button
              id="enviar-archivo"
              class="btn btn-success"
              type="submit"
            >
            Enjviar
            </button>

          </div>

          
        <div class="exterior-loader"><div id='preloader' class="preloader"></div></div>
      <!-- </div> -->
      <div id="respuesta-carga"></div>
    </form>
  </div>
<!-- </div> -->
@endsection

@section('utilities')
<script type="text/javascript">
	$(function() {
		$('#carga-form').submit(function(event) {
			event.preventDefault();
			$("#preloader").css("display", "block");
			$.ajax({
				url: "{{ route('cargadatos') }}",
				type: "POST",
				data: new FormData(this),
				contentType: false,
				processData: false,
				cache: false,
				success: function(response) {
					if (response.type == "error") {
						$("#respuesta-carga").css("color", "red");
						$("#respuesta-carga").html("ERROR: " + response.message);
					} else {
						$("#respuesta-carga").css("color", "green");
						$("#respuesta-carga").html("HECHO: " + response.message);
						$("#carga-form")[0].reset();
					}
				},
				error: function(response) {
					$("#respuesta-carga").css("color", "red");
					$("#respuesta-carga").html("ERROR: Hubo un error desconocido al subir el archivo CSV, inténtelo nuevamente");
					$("#preloader").css("display", "none");
				}
			}).done(function() {
				$("#preloader").css("display", "none");
			});
		});
	});
</script>
@endsection
