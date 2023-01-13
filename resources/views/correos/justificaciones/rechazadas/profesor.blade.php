@component('mail::message')
# Estimado(a):

Le informamos que la justificación realizada por el alumno <strong>{{ $nombreAlumno }}</strong>
ingresada el día <strong>{{ date('d-m-Y', strtotime($fechaSolicitud)) }}</strong>
ha sido <strong>RECHAZADA</strong> por su coordinador(a).
El alumno también fue informado de esta resolución.

## Detalle Solicitud

* Rut: {{ $rutAlumno }}
* Nombre: {{ $nombreAlumno }}
* Carrera: {{ $carreraAlumno }}
* Fecha justificada: {{ $fechaJustificacion }}
* Asignatura: {{ $asignatura }}
* Coordinador: {{ $nombreCoordinador }}
* Resolución: {{ $resolucion }}

<i>Sistema de Justificaciones, {{ date('Y') }}.</i>
@endcomponent
