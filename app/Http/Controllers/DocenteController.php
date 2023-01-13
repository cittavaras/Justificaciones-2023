<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DocenteController extends Controller
{
    public $defaultTable = 'datos_semestre';

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
    public function create()
    {
        $result = DB::table($this->defaultTable)->distinct()->orderBy('NOM_ASIG', 'ASC')->get(['NOM_ASIG']);
        $result = json_decode(json_encode($result), true);

        return view('administrador.actualizar-docente', [
            'cursos' => $result,
        ]);
    }

    public function getDocente($seccion)
    {
        $docente = DB::table($this->defaultTable)->where('NOM_ASIG', $seccion)->get();
        return json_encode($docente);
    }

    public function update(Request $request)
    {
        DB::table('cambios_docente')->insert(
            [
                'fecha' => date("Y-m-d"),
                'seccion' => $request->seccion,
                'old_rut' => $request->old_rut,
                'new_rut' => $request->rut,
                'old_nombre' => $request->old_name,
                'new_nombre' => $request->name,
                'old_apellido' => $request->old_ape,
                'new_apellido' => $request->ape,
                'old_email' => $request->old_email,
                'new_email' => $request->email
            ]
        );

        $c = DB::table($this->defaultTable)->where('NOM_ASIG', $request->seccion)->update([
            'rut_doc' => $request->rut,
            'NOMBRE_DOC' => $request->name,
            'APEP_DOC' => $request->ape,
            'CORREO_DOC' => $request->email
        ]);

        $j = DB::table('justifications')->where([['ASIGNATURA', $request->seccion], ['ESTADO', 'Pendiente']])->update([
            'CORREO_DOC' => $request->email
        ]);

        $res = $c + $j;

        return json_encode($res);
    }

    public function getHistorial()
    {
        $res = DB::table('cambios_docente')
            ->orderBy('id', 'desc')
            ->get();

        return json_encode($res);
    }
}
