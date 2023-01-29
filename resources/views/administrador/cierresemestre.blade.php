@extends('layouts.admin') @section('content')
<div class="container">
  <div id="cierresemestre">
    <h1 class="t-h1">Exportar<span></span></h1>
    <div class="box1 pa">Exportar el registro de justificaciones.</div>
    <div class="file-area">
      <span
        data-href="/tasks"
        id="exportBtn"
        class="btn btn-success btn-sm"
        onclick="exportTasks(event.target);"
        >Exportar</span
      >
    </div>
    <div id="respuesta-carga"></div>
    <br>
    <br>
    <h1 class="t-h1">Respaldar & Limpiar<span></span></h1>
    <div class="box1 pa">
      Respaldar y limpiar el registro de justificaciones.
    </div>

    <p class="pa">
      Para continuar, por favor, escriba <b>cerrar semestre</b>:
      <input id="confirm" maxlength="15" />
    </p>

    <div class="file-area">
      <button id="limpiar" class="btn btn-success" type="submit" disabled>
        Cerrar Semestre
      </button>
    </div>
    <div class="exterior-loader">
      <div id="preloader" class="preloader"></div>
    </div>

  </div>
</div>

@endsection

@section('utilities')
<script type="text/javascript">
function exportTasks(_this) {
  let _url = $(_this).data('href');
  window.location.href = _url;
}
let confirm = document.getElementById('confirm');
let btnLimpiar = document.getElementById('limpiar');
let msg = document.getElementById('respuesta-carga');
confirm.oninput = function () {
  if (confirm.value === 'cerrar semestre') {
    btnLimpiar.removeAttribute('disabled');
  } else if (!btnLimpiar.hasAttribute('disabled')) {
    btnLimpiar.setAttribute('disabled', '');
  }
};
async function cierre() {
  let res = await fetch('{{ route('sqltomongo') }}');
  let justi = await res.json();
  return justi;
}
btnLimpiar.onclick = function () {
  cierre()
    .then((res) => {
      if (!res.ok) {
        throw new Error(res.message);
      }
      msg.classList.add('successMsg');
      msg.innerHTML = 'Procedimiento compleado exitosamente.';
    })
    .catch((res) => {
      msg.classList.add('errorMsg');
      msg.innerHTML = res;
    });
};
</script>
@endsection
