@extends("layouts.admin")

@section('css')
<link href="{{ asset('css/coordinadores.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div id="cont-asignar-coordinador">
	<h1 class="t-h1">
		Asignar 
		<span class="t-span">coordinador</span> 
	</h1>
	<div class="pa">
		<p>Ingrese los datos del coordinador que desea crear, una vez presionado el boton "Agregar" espere a la respuesta del 
			sistema para verificiar la inserción exitosa.
		</p>
	</div>
	<div class="pa">
		<p>Recuerde que al seleccionar una sección el coordinador creado remplazara al coordinador anterior, pero este ultimo
			 no sera borrado y quedara en sistema para un posible uso
		</p>
	</div>
	<form id="asignar-coordinador" method="POST">
		{{ csrf_field() }}

		<label for="carrera">Carrera: </label>
		<select name="carrera" id="carrera-coordinador">
			<option value="null">Seleccione una carrera</option>
			@foreach($cursos as $item)
			<option value="{{$item['COD_CARRERA'].' '.$item['CARRERA']}}">{{$item['COD_CARRERA'].' '.$item['CARRERA']}}</option>
			@endforeach
		</select>

		<!--
		<label for="seccion">Sección: </label>
		<select name="seccion" id="seccion-coordinador" disabled>
			<option value="null">Seleccione una sección</option>
		</select>
-->

		<label for="coordinador">Coordinador:</label>
		<select name="coordinador" id="coordinador" disabled>
			<option value="null">Seleccione un coordinador</option>
			@foreach($coordinadores as $coor)
			<option value="{{$coor['NOMBRE_COR'].' '.$coor['APEP_COR'].' '.$coor['APEM_COR']}}">{{$coor['NOMBRE_COR'].' '.$coor['APEP_COR'].' '.$coor['APEM_COR']}}</option>
			@endforeach
		</select>

		<input id="but-asignar-coordinador" type="submit" value="Agregar">
	</form>
	<div id="respuesta"></div>
</div>

@endsection

@section('utilities')
<script type="text/javascript">
	$(function() {
		$("#carrera-coordinador").change(function() {
			var carrera = $(this).val();

			if (carrera) {
				$.ajax({
					url: "/secciones/get/" + encodeURIComponent(carrera),
					type: "GET",
					dataType: "json",
					success: function(data) {
						$("#coordinador").find("option").not(":first").remove();
						data.forEach((e) => {
							var asig = e["NOM_ASIG"];
							var id = asig.substr(0, asig.indexOf(" "));
							console.log(asig + " " + id);
							$("#coordinador").append(new Option(asig, id));
						});
					},
					complete: function() {
						$("#coordinador").removeAttr("disabled");
					}
				});
			}
		});

		/** 
		$("#seccion-coordinador").change(function() {
			var seccion = $(this).val();

			if (seccion) {
				$.ajax({
					url: "/coordinador/get/" + encodeURIComponent($("#carrera").val()) + "/" + encodeURIComponent(seccion),
					type: "GET",
					dataType: "json",
					success: function(data) {
						var selectCoor = $("#coordinador");
						selectCoor.val(0);
						console.log(data);
						selectCoor.val(data[0]["NOMBRE_COR"] + " " + data[0]["APEP_COR"] + " " + data[0]["APEM_COR"]);
					},
					complete: function() {
						$("#coordinador").removeAttr("disabled");
					}
				});
			}
		});*/

		$("#but-asignar-coordinador").submit(function(event) {
			event.preventDefault();
			$.ajax({
				url: "{{ route('asignar-coordinador') }}",
				type: "POST",
				data: $(this).serialize(),
				success: function(response) {
					if (response.type == "error") {
						$("#respuesta").css("color", "red");
						$("#respuesta").html("ERROR: " + response.message);
					} else {
						$("#respuesta").css("color", "green");
						$("#respuesta").html("HECHO: " + response.message);
						$("#asignar-coordinador")[0].reset();
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
