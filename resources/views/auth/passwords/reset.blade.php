<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JUSTIFICACIONES - AVARAS</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
        <link href="{{ asset('build/css/mi_css.css') }}" rel="stylesheet">
    </head>
    <body class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="login_wrapper">
                        <div class="form login_form" style="position:relative;">
                            <div class="panel panel-default">
                                <section class="login_content">
                                    <form action="{{ route('password.request') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="container imagenLogo col-md-offset-3">
                                            <img src="{{ asset('build/images/ivaras.png') }}" class="img-responsive" alt="Cinque Terre" width="40%">
                                        </div>
                                        <h1 class="text-center">Reestablecer contraseña</h1>
                                        <div class="form-group row">
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="Correo electrónico" required>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group row">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña nueva" required>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group row">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar contraseña" required>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Reestablecer
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
