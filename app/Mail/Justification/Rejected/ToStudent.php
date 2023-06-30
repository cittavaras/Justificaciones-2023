<?php

namespace App\Mail\Justification\Rejected;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ToStudent extends Mailable
{
    use Queueable, SerializesModels;

    public $justification;
    public $teachers;
    public $subjects;
    public $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($justification, $teachers, $subjects, $student)
    {
        $this->justification = $justification;
        $this->teachers = $teachers;
        $this->subjects = $subjects;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::debug('Correo enviado del estado rechazado de la solicitud al alumno: ' . $this->justification->NOMBRE_ALUM);
        return $this->subject('Resolución de justificación')
            ->markdown('correos.justificaciones.rechazadas.alumno')
            ->with([
                // justification data
                'folio' => $this->justification->nfolio,
                'resolucion' => $this->justification->comentario_rec,
                'fechaSolicitud' => $this->justification->FEC_SOL,
                'fechaJustificacion' => $this->justification->FEC_JUS,

                // extra data
                'nombreProfesores' => $this->teachers,
                'rutAlumno' => $this->student['RUT_ALU'],
                'nombreAlumno' => $this->student['NOMBRE'],
                'carreraAlumno' => $this->student['CARRERA'],
                'asignaturas' => $this->subjects,
            ]);
    }
}
