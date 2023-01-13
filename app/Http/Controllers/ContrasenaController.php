<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class ContrasenaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contrasena.cambiar');
    }

    public function cambiar(ChangePasswordRequest $request)
    {
        $current_password = Auth::User()->password;
        if (Hash::check($request['actual'], $current_password)) {
            User::where('email', auth()->user()->email)->update([
                'activacion' => 1,
                'password' => Hash::make($request['nueva']),
            ]);
            if (auth()->user()->rol == 0) {
                $usuario = 'alumno';
            } elseif (auth()->user()->rol == 1) {
                $usuario = 'coordinador';
            } elseif (auth()->user()->rol == 2) {
                $usuario = 'administrador';
            }
            return redirect()->intended($usuario.'/index')->with('success', 'Contaseña modificada correctamente.                     Presiona x para cerrar');;
        } else {
            $error = array('current-password' => 'Please enter correct current password');
            return response()->json(array('error' => $error), 400);
        }
    }
}
