<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="application/javascript"
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script> 
    <link
      rel="stylesheet"
      href="https://unpkg.com/tailwindcss@1.8.10/dist/base.css"
    />
    {{--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    --}}
    <link href="{{ asset('css/newlayout.css') }}" rel="stylesheet" />
    
    <link
    href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    rel="stylesheet"
    />
    
    
      {{-- <link
      href="/vendors/font-awesome/css/font-awesome.min.css"
      rel="stylesheet"
      /> --}}
     
      
      <title>Justificaciones - Antonio Varas</title>
    </head>
    <body>
      {{-- <script async src="../vendors/jquery/dist/jquery.min.js"></script> --}}
      @if (auth()->user()->rol == 2)
      <div class="outer">
        <div class="container">
          <!-- leftnav -->
          <div class="leftnav">
            <ul>
              <a href="{{ url('/administrador/index') }}">
                <li><i class="fa fa-home"></i>Inicio</li>
              </a>
              <a href="#">
                <li><i class="fa fa-table"></i>Coordinadores</li>
              </a>
              <a href="#">
                <a href="/administrador/actualizar-docente">
                  <li><i class="fa fa-bar-chart-o"></i>Profesores</li>
                </a>
              </a>
              <a href="{{ url('/administrador/upload') }}">
                <li><i class="fa fa-upload"></i> Carga de Datos</li>
              </a>
            </ul>
          </div>
          <!-- topnav -->
          <div class="topnav">
            <p><?= ucfirst(strtolower(strtok(auth()->user()->name, " "))) ?></p>
          </div>
          <!-- main -->
          <div id="app" class="main">
            @yield("content")
        </div>
        <!-- footer -->
        <div class="footer">
          <p>DuocUC - Sede Antonio Varas</p>
        </div>
        <!-- logo -->
        <div class="logo">
          <p>Portal Justificaciones</p>
        </div>
      </div>
    </div>
    
    
    <script  src="{{ asset('js/app.js') }}"></script>
    @yield('utilities') @endif
  </body>
  </html>
  