@extends("layouts.admin")

@section('css')
<link href="{{ asset('css/coordinadores.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div id="cont-add-coordinador">
	<h1 class="t-h1">
		Agregar 
		<span class="t-span">coordinador</span> 
	</h1>
	<div class="pa">
		<p>Ingrese los datos del coordinador que desea crear, una vez presionado el boton "Agregar" espere a la respuesta del 
			sistema para verificiar la inserción exitosa.
		</p>
</div>
	<form id="add-coordinador" method="POST">
		{{ csrf_field() }}

		<label for="nombre">Nombre: </label>
		<input type="text" name="nombre" id="nombre">

		<label for="apaterno">Apellido Paterno: </label>
		<input type="text" name="apaterno" id="apaterno">

		<label for="amaterno">Apellido Materno: </label>
		<input type="text" name="amaterno" id="amaterno">

		<label for="correo">Correo: </label>
		<input type="email" name="correo" id="correo">

		<input id="but-add-coordinador" type="submit" value="Agregar">
	</form>
	<div id="respuesta"></div>
</div>

@endsection

@section('utilities')
<script type="text/javascript">
	$(function() {
		$("#add-coordinador").submit(function(event) {
			event.preventDefault();
			$.ajax({
				url: "{{ route('add-coordinador') }}",
				type: "POST",
				data: $(this).serialize(),
				success: function(response) {
					if (response.type == "error") {
						$("#respuesta").css("color", "red");
						$("#respuesta").html("ERROR: " + response.message);
					} else {
						$("#respuesta").css("color", "green");
						$("#respuesta").html("HECHO: " + response.message);
						$("#add-coordinador")[0].reset();
					}
				},
				error: function(response) {
					$("#respuesta").css("color", "red");
					$("#respuesta").html("ERROR: Hubo un error desconocido al agregar coordinador, inténtelo nuevamente");
				}
			});
		});
	});
</script>
@endsection
