<template>
  <div class="">
    <div class="form" id="carga-form">
      <h1>Carga de datos semestrales</h1>
      <p>
        El archivo debe contener los datos de los alumnos inscritos este
        semestre.
      </p>
      <p>Antes de continuar, por favor lea las instrucciones:</p>
    </div>
    <form
      @submit.prevent="onSubmit"
      id="carga-form"
      method="POST"
      :action="route"
      accept-charset="UTF-8"
      enctype="multipart/form-data"
    >
      <input type="hidden" name="_token" :value="csrf" />

      <!-- start file picker -->
      <div class="upload">
        <h3>Seleccione el archivo.</h3>
        <input
          id="archivo-csv"
          type="file"
          accept=".csv"
          name="archivo-csv"
          required
        />

        <button id="enviar-archivo" type="submit">Enviar</button>

        <div class="status">
          <div class="warning"></div>
          <div class="success"></div>
          <div class="error"></div>
        </div>
      </div>
      <!-- outer filepicker -->

      <div id="respuesta-carga">
        <div class="exterior-loader">
          <div id="preloader" class="preloader"></div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'UploadFile',
  props: ['route'],
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
    };
  },
  methods: {
    onSubmit: function(e) {
      document.getElementById('preloader').style.display = 'block';
      var formData = new FormData(event.target);
      $.ajax({
        url: this.$props.route,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function(result) {
          if (result == 'invalid') {
            $('#respuesta-carga').html('Error: formato inválido.');
          } else if (result == 'columns-not-match') {
            $('#respuesta-carga').css('color', 'red');
            $('#respuesta-carga').html(
              'Error: Las columnas del archivo fuente no coinciden.'
            );
          } else if (result == 'success') {
            $('#respuesta-carga').css('color', 'green');
            $('#respuesta-carga').html('El archivo fue cargado correctamente.');
          } else {
            $('#respuesta-carga').html(result);
            $('#carga-form')[0].reset();
          }
        },
        error: function(result) {
          $('#respuesta-carga').html('Error: ' + result);
        },
      }).done(function() {
        document.getElementById('preloader').style.display = 'none';
      });
    },
  },
};
</script>

<style>
.main {
  background-color: #f7f7f7;
}
</style>

<style scoped>
.main > * {
  margin-left: 90px;
}

.form {
  width: 330px;
  height: auto;
  border-radius: 15px;
}

h1 {
  font-size: 12px;
  text-transform: uppercase;
  font-weight: 600;
  color: grey;
}
p {
  margin-top: 20px;
  text-align: justify;
  text-justify: auto;
  color: rgb(87, 87, 87);
  letter-spacing: 0.6px;
  font-size: 14px;
}

.upload {
  margin-top: 35px;
  display: grid;
  justify-items: center;
  width: 330px;
  height: auto;
  background-color: #42b983;
  border-radius: 5px;
  overflow: hidden;
}

h3 {
  padding: 10px;
  text-transform: uppercase;
  font-size: 10px;
  background: #389e70;
  width: 100%;
}

.upload input {
  margin-top: 20px;
  margin-bottom: 19px;
}

/* button {
  padding: 10px;
  text-transform: uppercase;
  width: 70px;
  font-size: 11px;
  margin-bottom: 10px;
  color: rgb(83, 83, 83);
  background-color: rgb(213, 213, 213);
  border-width: 0 2px 2px 0;
  border-color: black;
  cursor: default;
} */

button {
  padding: 10px;
  text-transform: uppercase;
  width: 70px;
  font-size: 11px;
  margin-bottom: 10px;
  color: rgb(170, 170, 170);
  background-color: rgb(63, 63, 63);
  border-width: 0 2px 2px 0;
  border-color: black;
  cursor: default;
}

/* button:hover {
  background-color: black;
  color: rgb(146, 146, 146);
} */

button:active {
  border-width: 2px 0 0 2px;
  border-color: black;
}

.status {
  background: #4ea07b;
  width: 100%;
  display: flex;
  justify-content: flex-end;
  padding: 2px;
}

.status > * {
  display: inline-block;
  border-radius: 50%;
  width: 15px;
  height: 15px;
  margin: 1px;
}

.status .warning {
  background: rgb(253, 253, 47);
}
.status .success {
  background: rgb(168, 253, 41);
}
.status .error {
  background: rgb(247, 56, 56);
}

#respuesta-carga {
  margin-top: 10px;
  width: 330px;
  height: 40px;
  /* background: rgb(224, 224, 224); */
  color: black;

  display: flex;
  align-items: center;
  text-transform: uppercase;
  font-size: 11px;
}

/* spinner + response */
/* spinner + response */
/* spinner + response */

.exterior-loader {
  display: table;
  margin: 0 auto;
}

.preloader {
  display: none;
  width: 30px;
  height: 30px;
  border: 4px solid lightgrey;
  border-top: 4px solid #2a3f54;
  border-radius: 50%;
  animation-name: girar;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}

@keyframes girar {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
