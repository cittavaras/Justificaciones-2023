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

		$result = DB::table($table)->get();

		$result = json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		Storage::disk('public')->put('justis.json', $result);

		exec('cd ' . base_path() . ' ; ' . 'node atlas.js' . ' 2>&1', $out, $err);

		// captura el output enviado por atlas.js
		$rowsOut = $out[count($out) - 1];

		// verifica que el n de rows de la bd corresponda al n de documents ingresados a mongodb
		if ($rowsIn == $rowsOut) {
			// --> ok
			DB::table($table)->truncate();
			return response()->json(['ok' => true, 'message' => 'Procedimiento completado exitosamente.']);
		} else {
			// -> error
			return response()->json(['message' => 'Error en el respaldo de la tabla justificaciones.']);
		}
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
					$file->move(base_path('cargasemestral/'),'archivo-excel.xlsx');
					exec('python3.8 /root/Desarrollo/Justificaciones-2023/cargasemestral/carga_datos.py');
					exec('rm /root/Desarrollo/Justificaciones-2023/cargasemestral/archivo-excel.xlsx');
					$users = User::where('activacion','=','2')->get();
					foreach ($users as $user) {
						$user->password = Hash::make($user->password);
						$user->activacion = 0;
						$user->save();
					}
				}}}
								

	public function exportCsv(Request $request)
	{
		$fileName = 'tasks.csv';
		//    $tasks = Task::all();
		$tasks = DB::table('justifications')->get();

		$headers = array(
			"Content-type"        => "text/csv",
			"Content-Disposition" => "attachment; filename=$fileName",
			"Pragma"              => "no-cache",
			"Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
			"Expires"             => "0"
		);

		$columns = array('ID_DATO', 'NFOLIO', 'TIPO_INASISTENCIA', 'FECHA_SOL', 'FECHA_JUS', 'MOTIVO', 'ESTADO', 'MOTIVO_REC', 'COMENTARIO_REC', 'NOMBRE_ALUM', 'CORREO_ALUM', 'RUT_ALU', 'CORREO_COR', 'CORREO_DOC', 'CELULAR_ALUM', 'UPDATED_AT', 'ASIGNATURA');

		$callback = function () use ($tasks, $columns) {
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);

			foreach ($tasks as $task) {
				$row[$columns[0]]  = $task->ID_DATO;
				$row[$columns[1]]  = $task->NFOLIO;
				$row[$columns[2]]  = $task->TIPO_INASISTENCIA;
				$row[$columns[3]]  = $task->FEC_SOL;
				$row[$columns[4]]  = $task->FEC_JUS;
				$row[$columns[5]]  = $task->MOTIVO;
				$row[$columns[6]]  = $task->ESTADO;
				$row[$columns[7]]  = $task->MOTIVO_REC;
				$row[$columns[8]]  = $task->COMENTARIO_REC;
				$row[$columns[9]]  = $task->NOMBRE_ALUM;
				$row[$columns[10]]  = $task->CORREO_ALUM;
				$row[$columns[11]]  = $task->RUT_ALU;
				$row[$columns[12]]  = $task->CORREO_COR;
				$row[$columns[13]]  = $task->CORREO_DOC;
				$row[$columns[14]]  = $task->CELULAR_ALUM;
				$row[$columns[15]]  = $task->UPDATED_AT;
				$row[$columns[16]]  = $task->ASIGNATURA;

				fputcsv($file, array($row[$columns[0]], $row[$columns[1]], $row[$columns[2]], $row[$columns[3]], $row[$columns[4]], $row[$columns[5]], $row[$columns[6]], $row[$columns[7]], $row[$columns[8]], $row[$columns[9]], $row[$columns[10]], $row[$columns[11]], $row[$columns[12]], $row[$columns[13]], $row[$columns[14]], $row[$columns[15]], $row[$columns[16]]));
			}

			fclose($file);
		};

		return response()->stream($callback, 200, $headers);
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

			//Guardo en variable el coordinador y la carrera seleccionada
			$newCoordinador = $request -> input('coordinador');
			$newCurso = $request -> input('carrera');

			$codCurso = (int) filter_var($newCurso,FILTER_SANITIZE_NUMBER_INT);
			$datos_coordinador = DB::select("SELECT nombre_cor,apep_cor,apem_cor,correo_cor from datos_semestre WHERE concat_ws(' ',nombre_cor,apep_cor,apem_cor) LIKE ?",[$newCoordinador]);
			$correoCor = $datos_coordinador[0]->correo_cor;

			$nomCoordinador = $datos_coordinador[0]->nombre_cor;
            $apepCoordinador = $datos_coordinador[0]->apep_cor;
            $apemCoordinador = $datos_coordinador[0]->apem_cor;
			

			/*DB::table('datos_semestre')
				->where('cod_carrera',$codCurso)
				->update(['NOMBRE_CORR' => DB::raw($nomCoordinador) , 'APEP_COR'=> DB::raw($apepCoordinador) , 'APEM_COR'=> DB::raw($apemCoordinador) , 'CORREO_COR'=> DB::raw($correoCor)]);
			*/
			//$statement = "UPDATE datos_semestre SET NOMBRE_CORR = '$nomCoordinador' , APEP_CORR = '$apepCoordinador', APEM_COR = '$apemCoordinador' , CORREO_COR = '$correoCor' WHERE COD_CARRERA = '$codCurso'";

			//DB::statement("UPDATE datos_semestre SET NOMBRE_CORR = 'CAMILA' , APEP_CORR = 'GONZALEZ', APEM_COR = 'H' , CORREO_COR = 'cagonzalezh@duoc.cl' WHERE COD_CARRERA = 667215");

			/*DB::table('datos_semestre')
			->where('cod_carrera',$codCurso)
			->update(['NOMBRE_CORR' => $nomCoordinador , 'APEP_COR'=> $apepCoordinador , 'APEM_COR'=> $apemCoordinador , 'CORREO_COR'=> $correoCor ]);
			return response()->json(['message' => 'Data actualizada con exito'],200);
			*/

	

			echo $codCurso ;
			echo $newCoordinador;
			echo $correoCor;

		} else {
			$cursos = DB::table('datos_semestre')
				->select('CARRERA','COD_CARRERA','JORNADA')
				->distinct()
				->orderBy('CARRERA', 'ASC')
				->get();
			$cursos = json_decode(json_encode($cursos), true);

			
			
			$resultado = DB::table('datos_semestre')
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
