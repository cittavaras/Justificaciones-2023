<?php

namespace App\Mail\Justification\Approved;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        return $this->subject('Resolución de justificación')
            ->markdown('correos.justificaciones.aprobadas.alumno')
            ->with([
                // justification data
                'folio' => $this->justification->nfolio,
                'nombreAlumno' => $this->justification->NOMBRE_ALUM.' '.$this->justification->APEP_ALUM,
                'fechaJustificacion' => $this->justification->FEC_JUS,
                'resolucion' => $this->justification->COMENTARIO_REC,
                'fechaSolicitud' => $this->justification->FEC_SOL,

                // extra data
                'nombreProfesores' => $this->teachers,
                'rutAlumno' => $this->student['RUT_ALU'],
                'carreraAlumno' => $this->student['CARRERA'],
                'asignaturas' => $this->subjects,
            ]);
    }
}
