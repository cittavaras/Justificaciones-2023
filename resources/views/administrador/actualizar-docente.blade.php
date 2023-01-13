@extends("layouts.admin")

@section('css')
<link href="{{ asset('css/actualizarDocente.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
  <form enctype="multipart/form-data" action="{{ url('/updateDocente') }}" method="post" id="form-act-docente">
    <h1 class="t-h1">CURSO<span class="t-span">cambio de Docente</span></h1>
    
    <select class="form-control" id="seccion" name="seccion" placeholder="seccion">
      <option value="">Seleccionar Curso</option>
      @foreach($cursos as $item)
        <option value="{{$item['NOM_ASIG']}}">{{$item['NOM_ASIG']}}</option>
      @endforeach
    </select>

    {{-- old --}}
    <input type="text" name="old_rutDocente" maxlength="12" hidden>
    <input type="text" name="old_nombreDocente" hidden>
    <input type="text" name="old_apellidoDocente" hidden>
    <input type="text" name="old_correoDocente" pattern=".+@PROFESOR.DUOC.CL" hidden>
    {{-- new --}}
    <input type="text" name="rutDocente" class="form-control" oninput="formatPhone(this);" maxlength="12" placeholder="6.234.998-6" readonly>
    <input type="text" name="nombreDocente" class="form-control" placeholder="JUAN CARLOS" readonly>
    <input type="text" name="apellidoDocente" class="form-control" placeholder="MORENO" readonly>
    <input type="text" name="correoDocente" class="form-control" pattern=".+@PROFESOR.DUOC.CL" placeholder="JC.MORENO@PROFESOR.DUOC.CL" readonly>
    <button type="submit" class="btn btn-info" id="btn" disabled>Actualizar</button>
  </form>
    
    <div id="historial"></div>

</div>
@endsection
@section('utilities')

<script type="application/javascript">
  async function getHistorial() {
  let res = await fetch('{{ route('gethistorialcd') }}');
  let json = await res.json();
  return json;
}

function gHistorial(y) {
  getHistorial().then((res) => {
    makeHistorial(res, y);
  });
}

gHistorial();

function makeHistorial(f, y) {
  let output = '';
  output += `<div class='row header'>
                  <div class='date'>FECHA</div>
                  <div class='course'>CURSO</div>
                  <div class='from'>DESDE</div>
                  <div class='to'>HACIA</div>
              </div>`;

  f.forEach(function (e) {
    let i = e.seccion.indexOf(' ');

    output += `
      <div class='row'>
          <div class='date'>${e.fecha}</div>
          <div class='course'>
              <div class='seccion'>${e.seccion.split(' ')[0]}</div>
              <div class='curso'>${e.seccion.substr(i)}</div>
          </div>
          <div class='from'>
          <div>${e.old_nombre.toUpperCase()} ${e.old_apellido.toUpperCase()}</div>
              <div>${formatRut(e.old_rut)}</div>
              <div>${e.old_email.toUpperCase()}</div>
          </div>
          <div class='to'>
          <div>${e.new_nombre.toUpperCase()} ${e.new_apellido.toUpperCase()}</div>
              <div>${formatRut(e.new_rut)}</div>
              <div>${e.new_email.toUpperCase()}</div>
          </div>
      </div>
  `;
  });

  document.getElementById('historial').innerHTML = output;
  if (y) {
    document.getElementById('historial').children[1].classList.add('last');
  }
}

function formatPhone(obj) {
  let short = { 1: '.', 4: '.', 7: '-' };
  let large = { 2: '.', 5: '.', 8: '-' };

  let numbers = obj.value.replace(/\D/g, '');

  if (numbers.length < 9) {
    char = short;
  } else {
    char = large;
  }

  obj.value = '';
  for (var i = 0; i < numbers.length; i++) {
    obj.value += (char[i] || '') + numbers[i];
  }
}

function formatRut(e) {
  let short = { 1: '.', 4: '.', 7: '-' };
  let large = { 2: '.', 5: '.', 8: '-' };

  let numbers = e.replace(/\D/g, '');

  if (numbers.length < 9) {
    char = short;
  } else {
    char = large;
  }

  let output = '';
  for (var i = 0; i < numbers.length; i++) {
    output += (char[i] || '') + numbers[i];
  }
  return output;
}

function reset() {
  $('#btn').removeClass('btn-warning');
  $('#btn').removeClass('btn-success');
  $('#btn').addClass('btn-info');
  document.getElementById('btn').innerHTML = 'Actualizar';

  document.querySelector('input[name=rutDocente]').setAttribute('readonly', '');
  document
    .querySelector('input[name=nombreDocente]')
    .setAttribute('readonly', '');
  document
    .querySelector('input[name=apellidoDocente]')
    .setAttribute('readonly', '');
  document
    .querySelector('input[name=correoDocente]')
    .setAttribute('readonly', '');

  $('input[name=rutDocente]').val('');
  $('input[name=nombreDocente]').val('');
  $('input[name=apellidoDocente]').val('');
  $('input[name=correoDocente]').val('');

  document.getElementById('btn').setAttribute('disabled', '');
}

$(function () {
  $('#seccion').on('change', function () {
    reset();

    var seccion = $(this).val();
    if (seccion) {
      $.ajax({
        url: '/docente/get/' + seccion,
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {},
        success: function (data) {
          $('input[name=rutDocente]').val(data[0].rut_doc);
          $('input[name=nombreDocente]').val(data[0].NOMBRE_DOC);
          $('input[name=apellidoDocente]').val(data[0].APEP_DOC);
          $('input[name=correoDocente]').val(data[0].CORREO_DOC);
          $('input[name=old_rutDocente]').val(data[0].rut_doc);
          $('input[name=old_nombreDocente]').val(data[0].NOMBRE_DOC);
          $('input[name=old_apellidoDocente]').val(data[0].APEP_DOC);
          $('input[name=old_correoDocente]').val(data[0].CORREO_DOC);
        },
        complete: function () {
          formatPhone($('input[name=rutDocente]')[0]);
          document
            .querySelector('input[name=rutDocente]')
            .removeAttribute('readonly');
          document
            .querySelector('input[name=nombreDocente]')
            .removeAttribute('readonly');
          document
            .querySelector('input[name=apellidoDocente]')
            .removeAttribute('readonly');
          document
            .querySelector('input[name=correoDocente]')
            .removeAttribute('readonly');
          document.getElementById('btn').removeAttribute('disabled');
        },
      });
    }
  });
});

$(document).ready(function () {
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  // process the form
  $('form').submit(function (event) {
    // get the form data
    // there are many ways to get this data using jQuery (you can use the class or id also)
    var formData = {
      _token: CSRF_TOKEN,
      seccion: $('select[name=seccion]').val(),
      rut: $('input[name=rutDocente]').val().replace(/\D/g, ''),
      name: $('input[name=nombreDocente]').val().toUpperCase(),
      ape: $('input[name=apellidoDocente]').val().toUpperCase(),
      email: $('input[name=correoDocente]').val().toUpperCase(),
      old_rut: $('input[name=old_rutDocente]').val().replace(/\D/g, ''),
      old_name: $('input[name=old_nombreDocente]').val().toUpperCase(),
      old_ape: $('input[name=old_apellidoDocente]').val().toUpperCase(),
      old_email: $('input[name=old_correoDocente]').val().toUpperCase(),
    };

    // process the form
    $.ajax({
      type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url: '/updateDocente', // the url where we want to POST
      data: formData, // our data object
      dataType: 'json', // what type of data do we expect back from the server
      encode: true,
    })
      // using the done promise callback
      .done(function (data) {
        if (data > 0) {
          gHistorial(true);
          document.getElementById('btn').innerHTML = 'Actualizado';
          $('#btn').removeClass('btn-info');
          $('#btn').addClass('btn-success');
          setTimeout(function () {
            reset();
            document.getElementById('seccion').value = '';
          }, 1500);
        } else {
          document.getElementById('btn').innerHTML = 'No hubo cambios';
          $('#btn').removeClass('btn-warning');
          $('#btn').removeClass('btn-success');
          $('#btn').addClass('btn-danger');
          setTimeout(function () {
            document.getElementById('btn').innerHTML = 'Inténtelo nuevamente.';
            $('#btn').removeClass('btn-danger');
            $('#btn').addClass('btn-warning');
          }, 1000);
        }

        // here we will handle errors and validation messages
      });

    // stop the form from submitting the normal way and refreshing the page
    event.preventDefault();
  });
});

</script>
 @endsection