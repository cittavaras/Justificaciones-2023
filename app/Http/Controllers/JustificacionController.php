<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;
use App\Http\Controllers\Controller;
use App\Justification;
use Carbon\Carbon;

use App\Events\Justification\Submitted as JustificationSubmitted;
use App\Events\Justification\Approved as JustificationApproved;
use App\Events\Justification\Rejected as JustificationRejected;



use App\Exports\JustificationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;



use DB;

class JustificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('alumno.index');
    }


    public function export()
    {
        return Excel::download(new JustificationsExport, 'justificaciones.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->activacion == 0) {
            logger("############################################33CONSOLA");
            return view('contrasena.cambiar', []);
        }

        $result = DB::table('datos_semestre')->where('correo_alum', auth()->user()->email)->get();  // DATOS USUARIO COMPLETOS
        logger($result);
	$result = json_decode(json_encode($result), true);
        $datosAlumno = DB::table('datos_semestre')->where('correo_alum', auth()->user()->email)->first();
        $time = Carbon::now();
        $folio = date_format($time, 'Y') . date_format($time, 'm') . str_random(8);
        return view('alumno.crearJustificacion', [
            'datosAlumno' => $datosAlumno,
            'infoCursos' => $result,
            'folio' => $folio
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * test
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactFormRequest $request)
    {
        //actualizar numero de telefono alumno
        DB::table('datos_semestre')
            ->where('correo_alum', auth()->user()->email)
            ->update(['celular' =>  $request['celular_alum']]);
        //guardar justificacion
        foreach (json_decode($request->cursosArray, true) as $curso) {
            $justification = new Justification();
            $justification->correo_cor = $curso['correoCoordinador'];
            $justification->correo_doc = $curso['correoDocente'];
            $justification->asignatura = $curso['asignatura'];
            //$justification->asignatura = $curso['asignatura'].' '.$curso['seccion'].'|';
            $justification->comentario = $request['comentario'];
            $justification->motivo = $request['motivo'];
            $justification->nombre_alum = $request['nombre_alum'] . ' ' . $request['apep_alum'] . ' ' . $request['apem_alum'];
            $justification->rut_alu = $request['rut_alu'];
            //$justification->nombre_alum = $request['nombre_alum'].' '.$request['apep_alum'].' '.$request['apem_alum'].' '.$curso['seccion'];
            $justification->correo_alum = $request['correo_alum'];
            $justification->celular_alum = $request['celular_alum'];
            $justification->fec_jus = $request['fechaJustificacion'];
            $justification->nfolio = $request['folio'];
            $justification->estado = 'Pendiente';
            $justification->motivo_rec = 'Pendiente';
            $justification->comentario_rec = 'Pendiente';
            $justification->tipo_inasistencia = $request['tipoInasistencia'] == "evaluacion" ? 1 : 0;
            $justification->save();
        }
#        event(new JustificationSubmitted($request['folio'])); GENERA EVENTO
        return redirect()->intended('alumno/index')->with('success', 'Justificacion creada correctamente.                    Presiona x para cerrar');
    }

    public function revisar()
    {
        if (auth()->user()->activacion == '0') {
            logger("############################################33CONSOLA");
            return view('contrasena.cambiar', []);
        }
        $justificacion  = Justification::where([['correo_alum', 'like', auth()->user()->email]])->get();
        $cantEmitidas   = Justification::where('correo_alum', 'like', auth()->user()->email)->count();
        $cantAprobadas  = Justification::where([['correo_alum', 'like', auth()->user()->email], ['estado', 'like', 'aprobada']])->count();
        $cantRechazadas = Justification::where([['correo_alum', 'like', auth()->user()->email], ['estado', 'like', 'rechazada']])->count();
        $cantValidando  = Justification::where([['correo_alum', 'like', auth()->user()->email], ['estado', 'like', 'validando']])->count();
        return view('alumno.revisarJustificacion', [
            'justificacion'  => $justificacion,
            'cantEmitidas'   => $cantEmitidas,
            'cantAprobadas'  => $cantAprobadas,
            'cantRechazadas' => $cantRechazadas,
            'cantValidando'  => $cantValidando
        ]);
    }

    public function getAsignaturas($asignaturaId)
    {
        $user = auth()->user();
        $asignatura = DB::table('datos_semestre')->where([
            ['NOM_ASIG', 'like', $asignaturaId],
            ['CORREO_ALUM', 'like', $user->email],
        ])->get();
        return json_encode($asignatura);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Datos de la justificacion
        $justifications = DB::table('justifications')
            ->where('nfolio', 'like', $id)
            ->first();

        //datos semestre alumno
        $datosAlumno = DB::table('datos_semestre')->where([
            ['correo_alum', 'like', $justifications->CORREO_ALUM]
        ])->first();

        if ($datosAlumno === null) {
            return view('coordinador.error');
        }

        //asignaturas justificadas
        $listaAsignaturasJustificadas = DB::table('justifications')
            ->select('ASIGNATURA')
            ->where('nfolio', 'like', $id)
            ->groupby('ASIGNATURA')
            ->get();

        $imagenes = DB::table('documento')
            ->select('url', 'nfolio', 'url')
            ->where('nfolio', 'like', $id)
            ->get();
        //rut y telefono alumno
        $alumno = DB::table('datos_semestre')
            ->select('celular', 'rut_alu')
            ->where('correo_alum', 'like', $justifications->CORREO_ALUM)
            ->first();
        return view('coordinador/edicionJustificaciones', [
            'justifications' => $justifications,
            'listaAsignaturasJustificadas' => $listaAsignaturasJustificadas,
            'datosAlumno' => $datosAlumno,
            'imagenes' => $imagenes,
            'folio' => $justifications->NFOLIO,
            'alumno' => $alumno
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Justification::whereFolio($request->folio)->update([
            'estado' => $request->estado,
            'comentario_rec' => $request->comentarioRechazo
        ]);
        $justificacion = Justification::whereFolio($request->folio)->first();
        if ($request->estado == 'Aprobado') {
            event(new JustificationApproved($justificacion));
        } else {
            event(new JustificationRejected($justificacion));
        }
        return redirect()->action('CoordinadorController@index');
    }
}
