<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    {{-- <link rel="icon" href="/public/favicon.ico" type="image/ico" /> --}}
    {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}
    <title>Justificaciones - Antonio Varas</title>

    <!-- Bootstrap -->
    
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/old.css') }}" rel="stylesheet" />

    @yield('css')
    <?php
    /*
    <!-- Font Awesome -->
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    */
    ?>

    <!-- Custom Theme Style -->
    
    <?php
    /*

    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    */
    ?>
  </head>


  @if (auth()->user()->rol == 2)
    <body class="nav-md">
      <div class="container body">
        <div class="main_container">
          <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
              <div class="navbar nav_title" style="border: 0;">
                <a href="{{ url('/administrador/index') }}" class="site_title"><span></span></a>
              </div>

              <div class="clearfix"></div>
              <br />

              <!-- sidebar menu -->
              <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                  <h3></h3>
                  <ul class="nav side-menu">
                    <li><a href="{{ url('/administrador/index') }}"><i class="fa fa-home"></i> Inicio </a></li>
                    <li><a><i class="fa fa-table"></i>Docentes <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="{{url('/administrador/actualizar-docente')}}">Cambio de Sección</a></li>
                      </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-user"></i>Coordinadores <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{url('/administrador/agregar-coordinador')}}">Agregar coordinador</a></li>
                            <li><a href="{{url('/administrador/asignar-coordinador')}}">Asignar coordinador</a></li>
                        </ul>
                    </li>
                    {{-- <li><a><i class="fa fa-bar-chart-o"></i> Datos y Estadisticas <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="{{ url('#') }}">Datos Por Coordinador</a></li>
                        <li><a href="{{ url('#') }}">Datos Por Carrera</a></li>
                        <li><a href="{{ url('#') }}">Datos Por Periodo</a></li>
                        <li><a href="{{ url('#') }}">Datos Historicos</a></li>
                        <li><a href="#">Otros Datos</a></li>
                      </ul>
                    </li> --}}
                    <!-- <li><a><i class="fa fa-bar-chart-o"></i> Datos y Estadisticas <span class="fa fa-chevron-down"></span></a> -->
                     
                      <li><a href="{{ url('/administrador/upload') }}"><i class="fa fa-cloud-upload"></i>Datos Semestrales</a></li>
                      <li><a href="{{ url('/administrador/cierresemestre') }}"><i class="fa fa-tasks"></i>Cierre de Semestre</a></li>
                      <li><a href="{{ url('/administrador/config') }}"><i class="fa fa-sliders"></i>Opciones</a></li>
                       
                    <!-- </li> -->
                  </ul>
                </div>
              </div>
              <!-- /sidebar menu -->

            </div>
          </div>

          <!-- top navigation -->
          <div class="top_nav">
            <div class="nav_menu">
              <nav>
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>

                <ul class="nav navbar-nav navbar-right">
                  <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      {{ auth()->user()->name }}
                      {{-- <img src="images/img.jpg" alt=""> --}}
                      
                      <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                      <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Salir') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                      </li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          <!-- /top navigation -->
          @show
          <!-- page content -->
          <div class="right_col" role="main">
            <div id="appp">
              @yield('content')
            </div>
          </div>
          

          <!-- /page content -->

          <!-- footer content -->
          <footer>
            <div class="pull-right">
              Sistema de Justificaciones - Sede Antonio Varas
            </div>
            <div class="clearfix"></div>
          </footer>
          <!-- /footer content -->
        </div>
      </div>

      <script async src="{{mix('js/app.js')}}"></script>

      {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
      <!-- jQuery -->
      <script src="../vendors/jquery/dist/jquery.min.js"></script>
      <!-- Bootstrap -->
      <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
      <?php
      /* 
      <!-- FastClick -->
      <script src="../vendors/fastclick/lib/fastclick.js"></script>
      <!-- NProgress -->
      <script src="../vendors/nprogress/nprogress.js"></script>

      */
      ?>
      @yield('utilities')

      <?php 
      /*
      <!-- Chart.js -->
      <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
      <!-- gauge.js -->
      <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
      <!-- bootstrap-progressbar -->
      <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
      <!-- iCheck -->
      <script src="../vendors/iCheck/icheck.min.js"></script>
      <!-- Skycons -->
      <script src="../vendors/skycons/skycons.js"></script>
      <!-- Flot -->
      <script src="/vendors/Flot/jquery.flot.js"></script>
      <script src="/vendors/Flot/jquery.flot.pie.js"></script>
      <script src="/vendors/Flot/jquery.flot.time.js"></script>
      <script src="/vendors/Flot/jquery.flot.stack.js"></script>
      <script src="/vendors/Flot/jquery.flot.resize.js"></script>
      <!-- Flot plugins -->
      <script src="/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
      <script src="/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
      <script src="/vendors/flot.curvedlines/curvedLines.js"></script>
      <!-- DateJS -->
      <script src="/vendors/DateJS/build/date.js"></script>
      <!-- JQVMap -->
      <script src="/vendors/jqvmap/dist/jquery.vmap.js"></script>
      <script src="/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
      <script src="/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
      <!-- bootstrap-daterangepicker -->
      <script src="/vendors/moment/min/moment.min.js"></script>
      <script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

      <!-- Datatables -->
      <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
      <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
      <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
      <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
      <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
      <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
      <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
      <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
      <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
      <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
      <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
      <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
      <script src="../vendors/jszip/dist/jszip.min.js"></script>

      */
      ?>
      <!--
      <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
      <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
      -->
            
      <!-- Custom Theme Scripts -->
      <script src="/build/js/custom.min.js"></script>
    </body>
  @endif
</html>
