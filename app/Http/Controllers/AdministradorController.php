<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Traits\Justificaciones;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\User;

class AdministradorController extends Controller
{
	use Justificaciones;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$coordinadores  = self::getCoordinadoresJustifications();
		$cantAprobadas  = $this->contarJustificaciones('Aprobado');
		$cantRechazadas = $this->contarJustificaciones('Rechazado');
		$cantPendientes = $this->contarJustificaciones('Pendiente');
		$cantEmitidas   = $this->contarJustificaciones('');
		return view('administrador.index', [
			'coordinadores'  => $coordinadores,
			'cantEmitidas'   => $cantEmitidas,
			'cantAprobadas'  => $cantAprobadas,
			'cantRechazadas' => $cantRechazadas,
			'cantPendientes' => $cantPendientes
		]);
	}


	public function getCoordinadoresJustifications()
	{
		$subQuery = DB::table('justifications')
			->select('nfolio', 'ESTADO', 'CORREO_COR')
			->groupby('nfolio', 'ESTADO', 'CORREO_COR');

		return DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
			->mergeBindings($subQuery)
			->select(DB::raw("CORREO_COR,
			count(if(estado = 'Aprobado',1, null))  as Aprobadas,
			count(if(estado = 'Rechazado',1, null)) as Rechazadas,
			count(if(estado = 'Pendiente',1, null)) as Pendientes,
			count(*) as Total"))
			->where('correo_cor', '!=', ' ')
			->groupby('correo_cor')
			->get();
	}

	public function config()
	{
		$status = DB::table('config')->where('name', 'status')->get()->first();

		return response()->json($status->value);
	}

	public  function togglePortal()
	{
		$status = DB::table('config')->where('name', 'status')->get()->first();

		if ($status->value == 0) {
			$res = DB::table('config')->where('name', 'status')->update([
				'value' => 1
			]);
		}

		if ($status->value == 1) {
			$res = DB::table('config')->where('name', 'status')->update([
				'value' => 0
			]);
		}

		$newStatus = DB::table('config')->where('name', 'status')->get()->first();

		if ($res == 1) {
			return response()->json(['ok' => true, 'status' => $newStatus->value, 'message' => 'Procedimiento completado exitosamente.']);
		} else {
			return response()->json(['message' => 'Hubo un error.']);
		}
	}

	public function sqlToMongo()
	{
		$table = 'justifications';
		$rowsIn = DB::table($table)->count();

		if ($rowsIn == 0) {
			return response()->json(['message' => 'La tabla justificaciones está vacía.']);
		}

		// verifica no existan justificaciones pendientes
		$cant_pendientes = DB::table($table)->where('ESTADO', 'Pendiente')->count();

		if ($cant_pendientes > 0) {
			return response()->json(['message' => 'Hay justificaciones pendientes.']);
		}
		
		exec('python3.8 '.base_path().'/public/convert_json.py');
		//exec('cd ' . base_path() . ' ;' . 'node atlas.js' ., $out, $err);
		//$rowsOut = $out[count($out)];
		//if ($rowsIn == $rowsOut) {
			// --> ok
		//	DB::table($table)->truncate();
		//	return response()->json(['ok' => true, 'message' => 'Procedimiento completado exitosamente.']);
		//} else {
		//	// -> error
		//	return response()->json(['message' => 'Error en el respaldo de la tabla justificaciones.']);
		//////}
	}

	public function cargar_datos(Request $request)
	{
			// Si la petición no lleva el archivo consigo
		if (!$request->hasFile('archivo-xlsx')) {
			return response()->json(['type' => 'error', 'code' => 'not-arrived', 'message' => 'El archivo no ha llegado al servidor, inténtelo nuevamente']);
		} else {
			// Variables que guardan los datos básicos del archivo recién subido
			$file = $request->file('archivo-xlsx');           // Objeto del archivo
			$filename = $file->getClientOriginalName();      // Nombre del archivo
			$file_ext = $file->getClientOriginalExtension(); // Extensión del archivo
			if (strtolower($file_ext) != 'xlsx') {
				return response()->json(['type' => 'error', 'code' => 'invalid-format', 'message' => 'El formato del archivo es inválido, asegúrese que sea formato XLSX']);
				}else{
					$file->move(base_path('cargasemestral/'),'archivo-excel-carga.xlsx');
					exec('python3.8 '.base_path().'/cargasemestral/carga_datos.py');
					exec('rm '.base_path().'/cargasemestral/archivo-excel-carga.xlsx');
					$users = User::where('activacion','=','2')->get();
					foreach ($users as $user) {
						$user->password = Hash::make($user->password);
						$user->activacion = 0;
						$user->save();
					}
				}}}
								

	public function exportCsv(Request $request)
	{
		    //PDF file is stored under project/public/download/info.pdf
		exec('python3.8 '.base_path().'/cargasemestral/convert_excel.py');
		$file= base_path(). "/public/archivo-excel.xlsx";

		$headers = [
			'Content-Type' => 'application/xlsx',
		];
  
 		return response()->download($file, 'archivo-excel.xlsx', $headers);
	}

	public function addCoordinador(Request $request)
	{
		if ($request->isMethod('POST')) {
			$data = $request->all();

			$nombre = $data['nombre'];
			$apaterno = $data['apaterno'];
			$amaterno = $data['amaterno'];
			$correo = $data['correo'];
			$carrera = $data['carrera'];
			$jornada = $data['jornada'];

			$success = DB::insert('insert into coordinadores (nombre_cor, apep_cor, apem_cor, correo_cor, jornada, cod_carrera) values (?, ?, ?, ?, ?, ?)', [$nombre, $apaterno, $amaterno, $correo, $jornada, $carrera]);
			$user = new User();
			$user->email = $data['correo'];
			$user->password = Hash::make(substr($data['correo'], 0, strpos($data['correo'], '@')));
			$user->name = strtoupper($data['nombre'] . ' ' . $data['apaterno'] . ' ' . $data['amaterno']);
			$user->rol = 1;
			$user->activacion = 2;
			$user->save();

			if ($success) {
				return response()->json(['type' => 'success', 'message' => 'El coordinador ha sido agregado']);
			} else {
				return response()->json(['type' => 'error', 'message' => 'No se ha podido agregar el nuevo coordinador']);
			}
		} else {
			$carreras = DB::table('carrera')->select('COD_CARRERA', 'NOMBRE_CARRERA')->get();
			$carreras = json_decode(json_encode($carreras), true);
			return view('administrador.add-coordinador', [
				'carreras' => $carreras
			]);
		}
	}

	public function asignarSeccionCoordinador(Request $request)
	{
		if ($request->isMethod('POST')) {
			$data = $request->all();
			$coordinador = $data['coordinador'];
			$id_carrera = $data['carrera'];
			if ($id_carrera == 'null'){
				echo 'Mal';
			}else{
				if ($coordinador == 'null'){
					echo 'Mal';
				}else{
					$id_carrera = filter_var($data['carrera'],FILTER_SANITIZE_NUMBER_INT);
					$id_carrera = substr($id_carrera,0,-1);
					$datos_coordinador = DB::select("SELECT nombre_cor,apep_cor,apem_cor,correo_cor from coordinadores WHERE concat_ws(' ',nombre_cor,apep_cor,apem_cor) LIKE (?)",[$coordinador]);
					$id_carrera_str = "$id_carrera".".0";
					$nombre_cor = $datos_coordinador[0]->nombre_cor;
					$apep_cor = $datos_coordinador[0]->apep_cor;
					$apem_cor = $datos_coordinador[0]->apem_cor;
					$correo_cor = $datos_coordinador[0]->correo_cor;
					DB::table('datos_semestre')
					->where('cod_carrera',$id_carrera_str)
					->update(array('NOMBRE_COR'=>$nombre_cor,'APEP_COR'=>$apep_cor,'APEM_COR'=>$apem_cor,'CORREO_COR'=>$correo_cor));
					return response()->json(['type' => 'success', 'message' => 'Se agrego']);
				}
			}	
		} else {
			$cursos = DB::table('datos_semestre')
				->select('CARRERA','COD_CARRERA','JORNADA')
				->distinct()
				->orderBy('CARRERA', 'ASC')
				->get();
			$cursos = json_decode(json_encode($cursos), true);

			$resultado = DB::table('coordinadores')
				->select('NOMBRE_COR','APEP_COR','APEM_COR')
				->distinct()
				->get();
			$resultado = json_decode(json_encode($resultado),true);

			return view('administrador.asignar-coordinador', [
				'cursos' => $cursos,
				'coordinadores' => $resultado
			]);
		}
	}

	


	public function getCoordinador($carrera, $seccion)
	{
		$seccion = rawurldecode($seccion);
		$coordinador = DB::table('datos_semestre')
			->select(DB::raw('TRIM(NOMBRE_COR) AS NOMBRE_COR, TRIM(APEP_COR) AS APEP_COR, TRIM(APEM_COR) AS APEM_COR'))
			->where([
				'CARRERA' => rawurldecode($carrera),
				\DB::raw('SUBSTRING(NOM_ASIG, 1, INSTR(NOM_ASIG, \' \'))') => $seccion

			])
			->distinct()
			->get();
		return json_encode($coordinador);
	}
}
