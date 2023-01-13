<?php

namespace App\Mail\Justification\Approved;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ToTeacher extends Mailable
{
    use Queueable, SerializesModels;

    public $justification;
    public $alumno;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($justification, $alumno)
    {
        $this->justification = $justification;
        $this->alumno = $alumno;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Resolución de justificación-APROBADA')
            ->markdown('correos.justificaciones.aprobadas.profesor')
            ->with([
                // Justification
                'fechaSolicitud' => $this->justification->FEC_SOL,
                'fechaJustificacion' => $this->justification->FEC_JUS,
                'asignatura' => $this->justification->ASIGNATURA,
                'resolucion' => $this->justification->COMENTARIO_REC,

                // student data
                'rutAlumno' => $this->alumno->RUT_ALU,
                'nombreAlumno' => $this->alumno->NOMBRE_ALUM.' '.$this->alumno->APEP_ALUM,
                'carreraAlumno' => $this->alumno->CARRERA,
                'seccionAlumno' => $this->alumno->COD_SECCION,
                'nombreCoordinador' => $this->alumno->NOMBRE_COR.' '.$this->alumno->APEP_COR,
            ]);
    }
}
