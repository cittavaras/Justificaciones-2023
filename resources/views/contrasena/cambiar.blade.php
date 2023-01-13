@if (auth()->user()->rol == 0)
  @extends('layouts.alumno')
@elseif (auth()->user()->rol == 1)
  @extends('layouts.coordinador')
@elseif (auth()->user()->rol == 2)
  @extends('layouts.admin')
@endif


@section('utilitiesHead')
  <!-- bootstrap-daterangepicker -->
  <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- Dropzone.js -->
  <link href="/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
    <style>
        #loader{
        visibility:hidden;
        }
    </style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Cambiar Contraseña</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{url('alumno/contrasena/cambiar')}}" aria-label="{{ __('Reset Password') }}">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="actual" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña Actual') }}</label>
                                                <div class="col-md-6">
                                                    <input id="actual" type="password" class="form-control" name="actual" required>
                                                    @if ($errors->has('actual'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('actual') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nueva" class="col-md-4 col-form-label text-md-right">{{ __('Nueva Contraseña') }}</label>

                                                <div class="col-md-6">
                                                    <input id="nueva" type="password" class="form-control" name="nueva" required>

                                                    @if ($errors->has('nueva'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('nueva') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="renueva" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                                                <div class="col-md-6">
                                                    <input id="renueva" type="password" class="form-control" name="nueva_confirmation" required>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Confirmar') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
