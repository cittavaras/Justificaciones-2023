<?php

namespace App\Http\Controllers;

use App\Justification;
use DB;
use Illuminate\Http\Request;

class SuperController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }
   public function index()
    {
        $listaJustificacionesValidando = DB::table('justifications')
            ->select('justifications.ID_DATO','NFOLIO', 'justifications.RUT_ALU', 'justifications.NOMBRE_ALUM', 'FEC_SOL', 'FEC_JUS', 'ASIGNATURA','ESTADO')
            ->join('datos_semestre', 'justifications.correo_alum', 'datos_semestre.correo_alum')
            ->where([['estado', 'like', 'Pendiente']])
            ->groupBy('justifications.ID_DATO','NFOLIO', 'RUT_ALU', 'justifications.NOMBRE_ALUM', 'FEC_SOL', 'FEC_JUS', 'ASIGNATURA','ESTADO')
            ->get();

        $listaJustificacionesAprobadas = DB::table('justifications')
            ->select('justifications.ID_DATO','NFOLIO', 'justifications.RUT_ALU', 'justifications.NOMBRE_ALUM', 'FEC_SOL', 'FEC_JUS', 'ASIGNATURA','ESTADO')
            ->join('datos_semestre', 'justifications.correo_alum', 'datos_semestre.correo_alum')
            ->where([['estado', 'like', 'Aprobado']])
            ->groupBy('justifications.ID_DATO','NFOLIO', 'RUT_ALU', 'justifications.NOMBRE_ALUM', 'FEC_SOL', 'FEC_JUS', 'ASIGNATURA','ESTADO')
            ->get();

        $listaJustificacionesRechazadas = DB::table('justifications')
            ->select('justifications.ID_DATO','NFOLIO', 'justifications.RUT_ALU', 'justifications.NOMBRE_ALUM', 'FEC_SOL', 'FEC_JUS', 'ASIGNATURA','ESTADO')
            ->join('datos_semestre', 'justifications.correo_alum', 'datos_semestre.correo_alum')
            ->where([['estado', 'like', 'Rechazado']])
            ->groupBy('justifications.ID_DATO','NFOLIO', 'RUT_ALU', 'justifications.NOMBRE_ALUM', 'FEC_SOL', 'FEC_JUS', 'ASIGNATURA','ESTADO')
            ->get();

        return view('super/index', [
            'listaJustificacionesValidando' => $listaJustificacionesValidando,
            'listaJustificacionesRechazadas' => $listaJustificacionesRechazadas,
            'listaJustificacionesAprobadas' => $listaJustificacionesAprobadas
        ]);
    }
}
