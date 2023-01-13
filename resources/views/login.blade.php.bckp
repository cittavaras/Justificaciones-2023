<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Justificaciones - Antonio Varas</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- NProgress -->
    {{-- <link href="../vendors/nprogress/nprogress.css" rel="stylesheet"> --}}
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('build/css/mi_css.css') }}" rel="stylesheet">
  </head>
  <body class="login">
    <div class="row cuerpo">
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form" style="position:relative">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <div class="panel panel-default">
            <section class="login_content">
              <form method="post" action="{{ route('login') }}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="container imagenLogo  col-md-offset-3">
                  <img src="{{ asset('build/images/ivaras.png') }}" class="img-responsive" alt="Cinque Terre" width="40%" >
                </div>
                <h1>Sistemas de Justificaciones</h1>
                <div>
                 <h6>Portal deshabilitado hasta inicio del segundo semestre. 05/08/2019 <span class="label label-default"></span></h6>
                </div>
                <div>
                 
                </div>
                <div>
                 
                </div>
                <div class="clearfix"></div>
              </form>
              <div>
                  <h6>Dudas a justificacionesavaras@gmail.com <span class="label label-default"></span></h6>
                 </div>
            </section>
          </div>
        </div>
        <div id="register" class="animate form registration_form">
          <div class="panel panel-default">
            <div class="container imagenLogoRegistro  col-md-offset-3">
              <img src="{{ asset('build/images/ivaras.png') }}" class="img-responsive" alt="Cinque Terre" width="40%" >
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
