<?php

namespace App\Http\Controllers;

use App\Justification;
use App\Traits\Justificaciones;
use DB;

class CoordinadorController extends Controller
{

    use Justificaciones;
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
        $verificar = DB::table('users')->select('activacion')->where('email', auth()->user()->email)->get();
        $listaJustificacionesValidando  = $this->listarJustificacionesPorEstado('Pendiente');
        $listaJustificacionesRechazadas = $this->listarJustificacionesPorEstado('Rechazado');
        $listaJustificacionesAprobadas  = $this->listarJustificacionesPorEstado('Aprobado');

        logger($listaJustificacionesValidando);
        logger($listaJustificacionesRechazadas);
        logger($listaJustificacionesAprobadas);

        return view('coordinador/index', [
            'listaJustificacionesValidando'  => $listaJustificacionesValidando,
            'listaJustificacionesRechazadas' => $listaJustificacionesRechazadas,
            'listaJustificacionesAprobadas'  => $listaJustificacionesAprobadas
        ]);
    }
}
