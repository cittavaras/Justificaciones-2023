@component('mail::message')
# Estimado(a):

Le informamos que la solicitud <strong>{{ $folio }}</strong> ha sido ingresada con éxito.
Su coordinador revisará la solicitud y la responderá a la brevedad.

## Detalle

* Rut: {{ $rutAlumno }}
* Nombre: {{ $nombreAlumno }}
* Carrera: {{ $carreraAlumno }}
* Asignaturas:
@foreach($asignaturas as $asignatura)
  * {{ $asignatura }}
@endforeach
* Docentes:
@foreach ($nombreProfes as $p)
  * {{ $p }}
@endforeach
* Comentario de alumno: {{ $comentario }}

¡Gracias!

<i>Sistema de Justificaciones, {{ date('Y') }}.</i>
@endcomponent
