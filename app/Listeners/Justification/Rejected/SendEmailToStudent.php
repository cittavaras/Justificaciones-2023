<?php

namespace App\Listeners\Justification\Rejected;

use App\Events\Justification\Rejected as JustificationRejected;
use App\Mail\Justification\Rejected\ToStudent as JustificationRejectedEmail;
use App\Justification;
use Mail;
use DB;

class SendEmailToStudent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(JustificationRejected $event)
    {
        $justifications = Justification::whereFolio($event->justification->NFOLIO)->get();
        $filteredJustifications = $justifications->unique('CORREO_DOC')->pluck('CORREO_DOC');
        $alumno = DB::table('datos_semestre')
            ->where('CORREO_ALUM', $event->justification->CORREO_ALUM)
            ->whereIn('CORREO_DOC', $filteredJustifications)
            ->get();

        $profesores = [];
        foreach ($alumno as $a) {
            array_push($profesores, $a->NOMBRE_DOC.' '.$a->APEP_DOC);
        }

        $alumnoFinal = [
            'RUT_ALU' => $alumno[0]->RUT_ALU,
            'NOMBRE' => $alumno[0]->NOMBRE_ALUM.' '.$alumno[0]->APEP_ALUM,
            'CARRERA' => $alumno[0]->CARRERA,
        ];

        Mail::to($event->justification->CORREO_ALUM)
            ->send(new JustificationRejectedEmail(
                $event->justification,
                $profesores,
                $justifications->pluck('ASIGNATURA')->all(),
                $alumnoFinal
            ));
    }
}
