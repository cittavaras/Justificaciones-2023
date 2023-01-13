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
		// Arreglo que contiene los nombres de las columnas y su respectivo orden
		$COLUMNAS_MATCH = array(
			'rut_alumno',
			'codigo_seccion',
			'nombre_asignatura',
			'nombre_alumno',
			'apellido_paterno_alumno',
			'apellido_materno_alumno',
			'correo_alumno',
			'telefono',
			'codigo_carrera',
			'carrera',
			'jornada',
			'id_docente',
			'nombre_docente',
			'apellido_paterno_docente',
			'apellido_materno_docente',
			'correo_docente',
			'nombre_coordinador',
			'apellido_paterno_coordinador',
			'apellido_materno_coordinador',
			'correo_coordinador'
		);

		// Si la petición no lleva el archivo consigo
		if (!$request->hasFile('archivo-csv')) {
			return response()->json(['type' => 'error', 'code' => 'not-arrived', 'message' => 'El archivo no ha llegado al servidor, inténtelo nuevamente']);
		} else {
			// Variables que guardan los datos básicos del archivo recién subido
			$file = $request->file('archivo-csv');           // Objeto del archivo
			$filename = $file->getClientOriginalName();      // Nombre del archivo
			$file_ext = $file->getClientOriginalExtension(); // Extensión del archivo

			// Si el archivo cargado no es tipo CSV
			if (strtolower($file_ext) != 'csv') {
				return response()->json(['type' => 'error', 'code' => 'invalid-format', 'message' => 'El formato del archivo es inválido, asegúrese que sea formato CSV']);
			} else {
				$file->move(base_path('cargasemestral/'), $filename);   // Almacena el archivo CSV en el directorio <proyecto>/cargasemestral
				$stored_csv = base_path('cargasemestral/' . $filename); // Variable que almacena la ruta del archivo CSV recién guardado

				// Bloque que permite la lectura del archivo CSV cargado
				if (($csv = fopen(base_path('cargasemestral/' . $filename), 'r')) !== FALSE) {
					// Obtiene los nombres de las columnas
					if (($data = fgetcsv($csv, 4096, ',')) !== FALSE) {
						$columnas_csv = $data; // Variable que va a retener las columnas del CSV

						// Ciclo para recorrer cada columna leída del CSV y comenzar el formateo
						for ($i = 0; $i < count($columnas_csv); $i++) {
							// Conversión a minúsculas
							$columna = strtolower($columnas_csv[$i]);

							// Elimina espacios alrededor de la columna
							$columna = trim($columna);

							// Reemplaza el espacio separador por _
							$columna = str_replace(' ', '_', $columna);

							// Elimina las acentuaciones de los caracteres
							$columna = strtr(
								utf8_decode($columna),
								utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
								'aaaaaceeeeiiiinooooouuuuyyaaaaaceeeeiiiinooooouuuuy'
							);

							// Guarda la columna formateada en la posición actual del arreglo de columnas
							$columnas_csv[$i] = $columna;
						}

						fclose($csv); // Cierra el archivo CSV

						// Si las columnas del CSV no coinciden con los nombres ni el orden requerido
						if ($columnas_csv !== $COLUMNAS_MATCH) {
							return response()->json(['type' => 'error', 'code' => 'columns-not-match', 'message' => 'Las columnas del archivo CSV']);
						} else {
							// Comienza la transformación del archivo CSV a SQL
							$old_path = getcwd();
							chdir(base_path('cargasemestral/'));
							shell_exec(base_path() . '/cargaSemestral_generarSQL.sh ' . base_path('cargasemestral/' . $filename));
							chdir($old_path);

							// Ejecuta el SQL de la carga semestral
							if (DB::unprepared(file_get_contents(base_path('cargasemestral/carga.sql')))) {
								// unlink(base_path('cargasemestral/' . $filename));
								// unlink(base_path('cargasemestral/carga.sql'));

								// Inserción de nuevos usuarios y cifrado de contraseñas
								DB::unprepared(file_get_contents(base_path() . '/insertarnuevosusuarios.sql'));

								$users = User::where('activacion', '=', '2')->get();
								foreach ($users as $user) {
									$user->password = Hash::make($user->password);
									$user->activacion = 0;
									$user->save();
								}

								return response()->json(['type' => 'success', 'code' => 'success', 'message' => '¡La carga semestral se ha realizado con éxito!!!!']);
							} else {
								return response()->json(['type' => 'error', 'code' => 'db-load-error', 'message' => 'Hubo un error en la base de datos durante la carga semestral']);
							}
						}
					}
				} else {
					return response()->json(['type' => 'error', 'code' => 'unreadable', 'message' => 'El archivo está ilegible o corrupto']);
				}
			}
		}
	}

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
			return response()->json(['message' => 'hola']);
		} else {
			$cursos = DB::table('datos_semestre')
				->select('CARRERA')
				->distinct()
				->orderBy('CARRERA', 'ASC')
				->get();
			$cursos = json_decode(json_encode($cursos), true);

			$coordinadores = DB::table('coordinadores')
				->select('NOMBRE_COR', 'APEP_COR', 'APEM_COR')
				->get();
			$coordinadores = json_decode(json_encode($coordinadores), true);

			return view('administrador.asignar-coordinador', [
				'cursos' => $cursos,
				'coordinadores' => $coordinadores
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
