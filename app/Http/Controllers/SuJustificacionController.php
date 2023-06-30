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

use DB;


class SuJustificacionController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $justifications = DB::table('justifications')->where('id_dato', 'like', $id)->first();
        //dd($justifications);
        $datosAlumno = DB::table('datos_semestre')->where([
            ['correo_alum', 'like', $justifications->CORREO_ALUM],
            ['nom_asig', 'like', $justifications->ASIGNATURA]
        ])->first();

        if ($datosAlumno === null) {
            return view('super.error');
        }

        $imagenes = DB::table('documento')
            ->select('url', 'nfolio')
            ->where('nfolio', 'like', $justifications->NFOLIO)
            ->get();

        return view('super/verJustificaciones', [
            'justifications' => $justifications,
            'datosAlumno' => $datosAlumno,
            'imagenes' => $imagenes,
            'folio' => $justifications->NFOLIO,
        ]);
    }
    public function edit($id)
    {
        $justifications = DB::table('justifications')->where('id_dato', 'like', $id)->first();

        $datosAlumno = DB::table('datos_semestre')->where([
            ['correo_alum', 'like', $justifications->CORREO_ALUM],
            ['nom_asig', 'like', $justifications->ASIGNATURA]
        ])->first();

        if ($datosAlumno === null) {
            return view('super.error');
        }

        $imagenes = DB::table('documento')
            ->select('url')
            ->where('nfolio', 'like', $justifications->NFOLIO)
            ->get();

        return view('super/suEdicionJustificaciones', [
            'justifications' => $justifications,
            'datosAlumno' => $datosAlumno,
            'imagenes' => $imagenes,
            'folio' => $justifications->NFOLIO,
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
        return redirect()->action('SuperController@index');
    }
}
