@extends('layouts.admin') @section('content')
<div class="container">
  <div id="cierresemestre">
    <h1 class="t-h1">Configuraciones</h1>

    <div class="config-box">
      <div class="status-box">
        El portal se encuentra: <span id="status"></span>
      </div>
      <p id="pr" hidden>
        Este procedimiento <span id="status-txt">..</span> el portal.
      </p>
      <p id="al" hidden>
        <i> Solo el Administrador podrá seguir accediendo a la plataforma. </i>
      </p>
    </div>

    <div class="file-area">
      <button
        id="toggleBtn"
        class="btn btn-success"
        type="submit"
        disabled
      ></button>
      <div class="exterior-loader2">
        <div id="preloader" class="preloader2" hidden></div>
      </div>
    </div>

    <div id="respuesta-carga"></div>
  </div>
</div>


@endsection

@section('utilities')
<script type="text/javascript">
let confirm = document.getElementById("confirm");
let msg = document.getElementById('respuesta-carga');
let status = document.getElementById('status');
let btn = document.getElementById('toggleBtn');
let alert = document.getElementById('al');
let loader  = document.getElementById('preloader');

async function getStatus(){
  let res = await fetch('{{ route('getconfig') }}');
  let json = await res.json();
  return json;
}

function toggle(res) {
  if (res == 1) {
      status.innerHTML = 'Activado';
      btn.innerHTML = 'Desactivar';
      btn.removeAttribute('disabled');
      al.removeAttribute('hidden');
    } else {
      status.innerHTML = 'Desactivado';
      btn.innerHTML = 'Activar';
     btn.removeAttribute('disabled');
     al.setAttribute('hidden', '');
    }
    loader.setAttribute('hidden', '')
}

getStatus()
  .then(res => {
    toggle(res)
})

async function cierre(){
  let res = await fetch('{{ route('toggleportal') }}');
  let justi = await res.json();
  return justi;
}

btn.onclick = function () {
  loader.removeAttribute('hidden')
  btn.setAttribute('disabled', '')
  
  cierre()
  .then(res => {
    
    if (!res.ok) {
      throw new Error(res.message);
    }
    
    toggle(res.status)

  })
  .catch(res => {
    msg.classList.add('errorMsg')
    msg.innerHTML = res
  })
}

</script>
@endsection
