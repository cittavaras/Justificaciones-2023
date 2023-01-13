<?php

namespace App\Mail\Justification\Submitted;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Requests\ContactFormRequest;

class ToStudent extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $teachers;
    public $justification;
    public $subjects;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student, $teachers, $justification, $subjects)
    {
        $this->student = $student;
        $this->teachers = $teachers;
        $this->justification = $justification;
        $this->subjects = $subjects;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Justificación ingresada')
            ->markdown('correos.justificaciones.creadas.alumno')
            ->with([
                'rutAlumno' => $this->student[0]->RUT_ALU,
                'nombreAlumno' => $this->student[0]->NOMBRE_ALUM.' '.$this->student[0]->APEP_ALUM.' '.$this->student[0]->APEM_ALUM,
                'nombreProfes' => $this->teachers,
                'nombreCoordinador' => $this->student[0]->NOMBRE_COR.' '.$this->student[0]->APEP_COR.' '.$this->student[0]->APEM_COR,
                'carreraAlumno' => $this->student[0]->CARRERA,
                'folio' => $this->justification->NFOLIO,
                'comentario' => $this->justification->COMENTARIO,
                'asignaturas' => $this->subjects,
            ]);
    }
}
