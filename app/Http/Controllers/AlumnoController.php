<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Traits\Justificaciones;
use DB;

class AlumnoController extends Controller
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
        $verificar = User::select('activacion')->where('email', auth()->user()->email)->get();
        logger(json_decode($verificar, true)[0]['activacion']);
        if (!json_decode($verificar, true)[0]['activacion']) {
            return view('contrasena.cambiar', []);
        }
        $justificacion  = $this->listarJustificacionesPorEstado('');
        $cantAprobadas  = $this->contarJustificaciones('Aprobado');
        $cantRechazadas = $this->contarJustificaciones('Rechazado');
        $cantPendientes = $this->contarJustificaciones('Pendiente');
        $cantEmitidas   = $this->contarJustificaciones('');
        logger($justificacion);
        //preguntar a ale que es logger
        return view('alumno.index', [
            'justificacion'  => $justificacion,
            'cantEmitidas'   => $cantEmitidas,
            'cantAprobadas'  => $cantAprobadas,
            'cantRechazadas' => $cantRechazadas,
            'cantPendientes' => $cantPendientes
        ]);
    }
    // Redirije al registro de justificaciones del alumno
    public function revisar(){
      return view('alumno.revisarJustificacion',
      ['justificacion'  => $this->listarJustificacionesPorEstado('')]);
    }

    public function show($id)
    {
        // Datos de la justificacion
         $datosJustificacion = DB::table('justifications')
          ->where('nfolio', 'like', $id)
          ->first();

         /*$listaAsignaturasJustificadas = DB::table('justifications')
          ->select('ASIGNATURA')
          ->where('nfolio', 'like', $id)
          ->groupby('ASIGNATURA')
          ->get();
          */

          $listaAsignaturasJustificadas = DB::table('justifications')
           ->select('nfolio','justifications.ASIGNATURA','datos_semestre.NOMBRE_DOC', 'datos_semestre.APEP_DOC')
           ->join('datos_semestre', 'justifications.CORREO_DOC', 'datos_semestre.CORREO_DOC')
           ->where([['justifications.nfolio', 'like', $id]])
           ->groupBy('nfolio', 'justifications.ASIGNATURA', 'datos_semestre.NOMBRE_DOC', 'datos_semestre.APEP_DOC')
           ->get();

        // Datos del semestre del alumno
        $datosAlumno = DB::table('datos_semestre')->where([
          ['correo_alum', 'like', auth()->user()->email]
          ])->first();

        $imagenes = DB::table('documento')
            ->select('url','nfolio')
            ->where('nfolio','like', $id)
            ->get();
        //dd($imagenes) ;
        return view('alumno/verJustificaciones', [
            'justifications' => $datosJustificacion,
            'listaAsignaturasJustificadas' => $listaAsignaturasJustificadas,
            'datosAlumno' => $datosAlumno,
            'imagenes' => $imagenes,
            'folio' => $id,
        ]);
    }
}
