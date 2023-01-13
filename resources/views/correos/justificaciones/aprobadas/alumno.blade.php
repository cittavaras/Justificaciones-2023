@component('mail::message')
# Estimado(a):

Le informamos que la solicitud <strong>{{ $folio }}</strong> de justificación
ha sido <strong>APROBADA</strong> por su coordinador(a)
ingresada el dia <strong>{{ date("d-m-Y", strtotime($fechaSolicitud)) }}</strong>.
Su docente será informado de esta situación.
Si justifica alguna evaluación, debe coordinar con el docente.

## Detalle Solicitud

* Rut: {{ $rutAlumno }}
* Nombre: {{ $nombreAlumno }}
* Carrera: {{ $carreraAlumno }}
* Fecha justificada: {{ $fechaJustificacion }}
* Docentes:
@foreach($nombreProfesores as $p)
  * {{ $p }}
@endforeach
* Asignaturas:
@foreach ($asignaturas as $a)
  * {{ $a }}
@endforeach
* Resolución: {{ $resolucion }}

Favor, conservar este mail.

<i>Sistema de Justificaciones, {{ date('Y') }}.</i>
@endcomponent
