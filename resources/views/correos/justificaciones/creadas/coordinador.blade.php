@component('mail::message')
# Estimado(a):

Le informamos que ha sido ingresada una nueva solicitud de justificación <strong>{{ $folio }}</strong>.
Favor, responder a la brevedad.

## Detalle

* Rut: {{ $rutAlumno }}
* Nombre: {{ $nombreAlumno }}
* Asignaturas:
@foreach ($asignaturas as $a)
  * {{ $a }}
@endforeach
* Docentes:
@foreach ($nombreProfes as $t)
  * {{ $t }}
@endforeach
* Comentario de alumno: {{ $comentario }}

¡Gracias!

<i>Sistema de Justificaciones, {{ date('Y') }}.</i>
@endcomponent
